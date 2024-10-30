<?php

namespace lameco\crafttwigcomponents;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use lameco\crafttwigcomponents\services\EntryHelper;
use Performing\TwigComponents\Configuration;
use Twig\Extra\Html\HtmlExtension;
use craft\web\View;
use lameco\crafttwigcomponents\assetBundles\AppBundle;
use lameco\crafttwigcomponents\services\PageBuilder;
use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * @property-read PageBuilder $pageBuilder
 * @property-read EntryHelper $entryHelper
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';

    public static function config(): array
    {
        return [
            'components' => [
                'pageBuilder' => PageBuilder::class,
                'entryHelper' => EntryHelper::class
            ],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $twig = Craft::$app->getView()->getTwig();

        if (Craft::$app->request->getIsSiteRequest()) {
            //Register AssetBundle for stimulus controller so that Craft auto-injects them on the website
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
                function (Event $event) use ($twig) {
                    Configuration::make($twig)
                        ->setTemplatesPath('lameco')
                        ->useCustomTags()
                        ->setup();
                }
            );
        }
    }
}
