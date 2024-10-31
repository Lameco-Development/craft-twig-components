<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\errors\EntryTypeNotFoundException;
use craft\fieldlayoutelements\CustomField;
use craft\fieldlayoutelements\Template;
use craft\helpers\Console;
use craft\models\FieldLayoutTab;
use JetBrains\PhpStorm\NoReturn;
use lameco\crafttwigcomponents\Plugin;
use Throwable;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Page Builder service
 */
class PageBuilder extends Component
{
    private EntryHelper $entryHelper;

    public function __construct()
    {
        parent::__construct();
        $this->entryHelper = Plugin::getInstance()->entryHelper;
    }

    /**
     * @throws Throwable
     * @throws InvalidConfigException
     * @throws EntryTypeNotFoundException
     */
    #[NoReturn] public function createBlock(string $name, string $handle, array $tabsConfig): void
    {
        $entries = Craft::$app->getEntries();
        $entryType = $this->entryHelper->createEntryType($name, $handle);
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
                        Console::outputWarning("Field $handle doesn't exist");
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
        $entryType->setFieldLayout($layout);

        if (!$entries->saveEntryType($entryType)) {
            Console::outputWarning("EntryType $handle could not be saved" . PHP_EOL . print_r($entryType->getErrors(), true));
            $entryType->validate();
        }
    }
}
