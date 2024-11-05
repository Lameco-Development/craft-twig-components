<?php

namespace lameco\crafttwigcomponents;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use lameco\crafttwigcomponents\services\EntryHelper;
use lameco\crafttwigcomponents\services\Migration;
use Performing\TwigComponents\Configuration;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extra\Html\HtmlExtension;
use craft\web\View;
use lameco\crafttwigcomponents\assetBundles\AppBundle;
use lameco\crafttwigcomponents\services\PageBuilder;
use lameco\crafttwigcomponents\models\Settings;
use yii\base\Event;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use craft\events\ModelEvent;

/**
 * @property-read PageBuilder $pageBuilder
 * @property-read EntryHelper $entryHelper
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                'pageBuilder' => PageBuilder::class,
                'entryHelper' => EntryHelper::class,
                'migration' => Migration::class
            ],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        Event::on(
            self::class,
            self::EVENT_BEFORE_SAVE_SETTINGS,
            function (ModelEvent $event) {
                $settings = $event->sender->getSettings();

                foreach ($settings->components as $component) {
                    $this->migration->migrateComponent($component['migration'], $component['enabled']);
                }
            }
        );

        $twig = Craft::$app->getView()->getTwig();

        if (Craft::$app->request->getIsSiteRequest()) {
            Craft::$app->view->registerAssetBundle(AppBundle::class);
        }

        Craft::$app->view->registerTwigExtension(new HtmlExtension());

        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function ($event) {
                $event->roots['lameco'] = $this->getBasePath() . '/templates/components';
            }
        );

        if (Craft::$app->request->getIsSiteRequest()) {
            Event::on(
                Plugins::class,
                Plugins::EVENT_AFTER_LOAD_PLUGINS,
                function () use ($twig) {
                    Configuration::make($twig)
                        ->setTemplatesPath('lameco')
                        ->useCustomTags()
                        ->setup();
                }
            );
        }
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws Exception
     * @throws LoaderError
     */
    protected function settingsHtml(): ?string
    {
        $availableFields = Craft::$app->getFields()->getAllFields();
        $availableFieldOptions = [
            [
                'label' => 'Select a field',
                'value' => null,
            ]
        ];

        foreach ($availableFields as $field) {
            $availableFieldOptions[] = [
                'label' => $field->name,
                'value' => $field->id,
            ];

        }

        return Craft::$app->view->renderTemplate('_craft-twig-components/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
            'availableFieldOptions' => $availableFieldOptions
        ]);
    }
}
