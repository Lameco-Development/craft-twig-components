<?php

namespace lameco\crafttwigcomponents\assetBundles;

use craft\web\AssetBundle;

class AppBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@lameco/crafttwigcomponents/web/dist';

        $this->js = [
            'assets/app.js',
        ];

        parent::init();
    }
}
