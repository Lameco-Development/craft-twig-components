<?php

namespace lameco\crafttwigcomponents;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\web\View;
use lameco\crafttwigcomponents\AssetsBundles\StimulusBundle;
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

        //Register custom template root so you can use "@lameco" alias for referencing to components in this plugin
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function ($event) {
                $event->roots['@lameco'] = $this->getBasePath() . '/templates';
            }
        );

        if (Craft::$app->request->getIsSiteRequest()) {
            //Register AssetBundle for stimulus controller so that Craft auto-injects them on the website
            Craft::$app->view->registerAssetBundle(StimulusBundle::class);
        }
    }
}
