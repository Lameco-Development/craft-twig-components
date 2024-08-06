<?php

namespace lameco\crafttwigcomponents\AssetsBundles;

use craft\web\AssetBundle;

class StimulusBundle extends AssetBundle
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
