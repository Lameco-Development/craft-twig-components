<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\enums\Color;
use craft\fieldlayoutelements\CustomField;
use craft\fieldlayoutelements\Template;
use craft\models\EntryType;
use craft\models\FieldLayoutTab;
use Exception;
use Throwable;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Entry Helper service
 */
class EntryHelper extends Component
{
    /**
     * @throws InvalidConfigException
     * @throws Exception|Throwable
     */
    public function createEntryType(string $name, string $handle, string $icon, bool $save = true, ?array $tabsConfig = []): EntryType
    {
        $entries = Craft::$app->getEntries();

        if ($entries->getEntryTypeByHandle($handle)) {
            throw new Exception("EntryType with handle $handle already exists" . PHP_EOL);
        }

        $config = [
            'class' => EntryType::class,
            'name' => $name,
            'handle' => $handle,
            'icon' => $icon,
            'color' => Color::Fuchsia,
            'hasTitleField' => false,
            'showSlugField' => true,
            'showStatusField' => true,
        ];

        $entryType = Craft::createObject(array_merge($config, []));

        if (count($tabsConfig) > 0) {
            $layout = $entryType->getFieldLayout();
            $tabs = [];

            foreach ($tabsConfig as $index => $config) {
                $elements = [];

                foreach ($config['fields'] as $field) {
                    if ($field instanceof Template) {
                        $elements[] = $field;
                    } else {
                        $existingField = Craft::$app->getFields()->getFieldByHandle($field['handle']);
                        if (!$existingField) {
                            throw new Exception("Field " . $field['handle'] . " doesn't exist" . PHP_EOL . print_r($entryType->getErrors(), true));
                        } else {
                            $elements[] = Craft::createObject([
                                'class' => CustomField::class,
                                'fieldUid' => $existingField->uid,
                                'required' => $field['required'] ?? false,
                                'label' => $field['label'],
                                'handle' => $field['mappedHandle'],
                                'width' => $field['width'] ?? 100
                            ]);
                        }
                    }
                }

                $tab = new FieldLayoutTab();
                $tab->layout = $layout;
                $tab->name = $config['name'];
                $tab->sortOrder = $index;

                $tab->setElements($elements);
                $tabs[] = $tab;
            }

            $layout->setTabs($tabs);
        }

        if ($save) {
            if (!$entries->saveEntryType($entryType)) {
                $entryType->validate();
                throw new Exception("EntryType $handle could not be saved" . PHP_EOL . print_r($entryType->getErrors(), true));
            }
        }

        return $entryType;
    }
}
