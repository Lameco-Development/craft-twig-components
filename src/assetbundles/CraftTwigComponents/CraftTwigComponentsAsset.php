<?php

namespace lameco\crafttwigcomponents\assetBundles\CraftTwigComponents;

use craft\web\AssetBundle;

class CraftTwigComponentsAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@lameco/crafttwigcomponents/assetbundles/CraftTwigComponents/dist';

        $this->js = [
            'assets/craftTwigComponents.js',
        ];

        $this->css = [
            'assets/craftTwigComponents.css',
        ];

        parent::init();
    }
}
