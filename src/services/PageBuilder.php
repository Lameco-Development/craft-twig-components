<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\errors\EntryTypeNotFoundException;
use craft\fieldlayoutelements\CustomField;
use craft\helpers\Console;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use lameco\crafttwigcomponents\Plugin;
use phpDocumentor\Reflection\Types\Parent_;
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
    #[NoReturn] public function createBlock(string $name, string $handle, array $existingFields): void
    {
        $entries = Craft::$app->getEntries();
        $entryType = $this->entryHelper->createEntryType($name, $handle);
        $elements = [];

        foreach ($existingFields as $existingField) {
            $field = Craft::$app->getFields()->getFieldByHandle($existingField['handle']);
            if (!$field) {
                Console::outputWarning("Field $handle doesn't exist");
            } else {
                $elements[] = Craft::createObject([
                    'class' => CustomField::class,
                    'fieldUid' => $field->uid,
                    'required' => false,
                    'label' => $existingField['label'],
                    'handle' => $existingField['mappedHandle']
                ]);
            }
        }

        $layout = $entryType->getFieldLayout();
        $tabs = $layout->getTabs();
        $tabs[0]->setElements(array_merge($tabs[0]->getElements(), $elements));
        $layout->setTabs($tabs);
        $entryType->setFieldLayout($layout);

        if (!$entries->saveEntryType($entryType)) {
            Console::outputWarning("EntryType $handle could not be saved" . PHP_EOL . print_r($entryType->getErrors(), true));
            $entryType->validate();
        }
    }
}
