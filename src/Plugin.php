<?php

namespace lameco\crafttwigcomponents;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use craft\web\View;
use lameco\crafttwigcomponents\AssetsBundles\AppBundle;
use modules\lameco\web\twig\WebtesterExtension;
use Performing\TwigComponents\Configuration;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use Twig\Extra\Html\HtmlExtension;
use yii\base\Event;
use yii\base\InvalidConfigException;

class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
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
