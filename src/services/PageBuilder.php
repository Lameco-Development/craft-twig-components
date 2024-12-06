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
use Exception;
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
    public function createBlock(string $name, string $handle, string $icon, array $tabsConfig): true
    {
        $entries = Craft::$app->getEntries();
        $entryType = Plugin::getInstance()->entryHelper->createEntryType($name, $handle, $icon, false, $tabsConfig);

        $this->addAnchorHintToTab($entryType);

        if (!$entries->saveEntryType($entryType)) {
            $entryType->validate();
            throw new Exception("EntryType $handle could not be saved" . PHP_EOL . print_r($entryType->getErrors(), true));
        } else {
            $pageBuilderFieldId = Plugin::getInstance()->getSettings()->pageBuilderFieldId;
            if ($pageBuilderFieldId !== null) {
                $this->addBlockToPageBuilderField($pageBuilderFieldId, $entryType);
            }
        }

        return true;
    }

    /**
     * @throws InvalidConfigException
     */
    private function addAnchorHintToTab(EntryType $entryType): void
    {
        $layout = $entryType->getFieldLayout();
        $tabs = $layout->getTabs();
        $tab = new FieldLayoutTab();
        $tab->layout = $layout;
        $tab->name = 'Anchor';
        $tab->setElements([
            Craft::createObject([
                'class' => Template::class,
                'template' => 'lameco/control-panel/anchor/element.twig'])]);

        $tabs[] = $tab;
        $layout->setTabs($tabs);
    }

    /**
     * @throws Exception
     */
    public function addBlockToSettingsModel(array $block): bool
    {
        $plugin = Plugin::getInstance();
        $settings = $plugin->getSettings();

        $settings->components[] = $block;

        if (!Craft::$app->plugins->savePluginSettings($plugin, $settings->getAttributes())) {
            throw new Exception('Failed to update plugin settings', __METHOD__);
        }

        return true;
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

            usort($entryTypes, function ($a, $b) {
                return strcmp($a->name, $b->name);
            });

            $field->setEntryTypes($entryTypes);

            if (!Craft::$app->fields->saveField($field)) {
                throw new Exception("Page Builder field `$field->name` could not be saved");
            }
        }
    }
}
