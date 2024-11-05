<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\errors\EntryTypeNotFoundException;
use craft\fieldlayoutelements\CustomField;
use craft\fieldlayoutelements\Template;
use craft\fields\Matrix;
use craft\helpers\Console;
use craft\models\EntryType;
use craft\models\FieldLayout;
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
    /**
     * @throws Throwable
     * @throws InvalidConfigException
     * @throws EntryTypeNotFoundException
     */
    #[NoReturn] public function createBlock(string $name, string $handle, array $tabsConfig): void
    {
        $entries = Craft::$app->getEntries();
        $entryType = Plugin::getInstance()->entryHelper->createEntryType($name, $handle);
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

        $this->addAnchorHintToTab($tabs, $layout);

        $layout->setTabs($tabs);
        $entryType->setFieldLayout($layout);

        if (!$entries->saveEntryType($entryType)) {
            Console::outputWarning("EntryType $handle could not be saved" . PHP_EOL . print_r($entryType->getErrors(), true));
            $entryType->validate();
        } else {
            $pageBuilderFieldId = Plugin::getInstance()->getSettings()->pageBuilderFieldId;
            if ($pageBuilderFieldId !== null) {
                $this->addBlockToPageBuilderField($pageBuilderFieldId, $entryType);
            }
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function addAnchorHintToTab(array &$tabs, FieldLayout $layout): void
    {
        $tab = new FieldLayoutTab();
        $tab->layout = $layout;
        $tab->name = 'Anchor';

        $tab->setElements([
            Craft::createObject([
                'class' => Template::class,
                'template' => '_helpers/admin/element.twig'])]);
        $tabs[] = $tab;
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     */
    private function addBlockToPageBuilderField(int $pageBuilderFieldId, EntryType $entryType): void
    {
        $field = Craft::$app->fields->getFieldById($pageBuilderFieldId);

        if ($field instanceof Matrix) {
            $entryTypes = [...$field->getEntryTypes(), $entryType];

            usort($entryTypes, function($a, $b) {
                return strcmp($a->name, $b->name);
            });

            $field->setEntryTypes($entryTypes);

            if (!Craft::$app->fields->saveField($field)) {
                Console::outputWarning("Page Builder field `$field->name` could not be saved");
            }
        }
    }
}
