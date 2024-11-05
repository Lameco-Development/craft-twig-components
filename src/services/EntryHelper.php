<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\enums\Color;
use craft\fieldlayoutelements\CustomField;
use craft\helpers\Console;
use craft\models\EntryType;
use Exception;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Entry Helper service
 */
class EntryHelper extends Component
{

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function createEntryType(string $name, string $handle): EntryType
    {
        $entries = Craft::$app->getEntries();
        $config = [
            'class' => EntryType::class,
            'name' => $name,
            'handle' => $handle,
            'icon' => 'cube',
            'color' => Color::Fuchsia,
            'hasTitleField' => false,
            'showSlugField' => true,
            'showStatusField' => true,
        ];

        if ($entries->getEntryTypeByHandle($handle)) {
            throw new Exception(`EntryType with handle "$handle" already exists`);
        }

        return Craft::createObject(array_merge($config, []));
    }
}
