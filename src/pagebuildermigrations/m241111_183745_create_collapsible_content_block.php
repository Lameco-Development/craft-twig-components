<?php

namespace lameco\crafttwigcomponents\pagebuildermigrations;

use Craft;
use craft\db\Migration;
use craft\enums\PropagationMethod;
use craft\fields\Matrix;
use craft\helpers\Console;
use lameco\crafttwigcomponents\Plugin;
use Throwable;

/**
 * m241111_183745_create_collapsible_content_block migration.
 */
class m241111_183745_create_collapsible_content_block extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        try {
            $itemsEntryType = Plugin::getInstance()->entryHelper->createEntryType('Page Builder - Collapsible Content - Items', 'pageBuilderCollapsibleContentItems', 'cubes', true, [
                [
                    'name' => 'Content',
                    'fields' => [
                        [
                            'label' => 'Title',
                            'handle' => 'commonCkeditorTitle',
                            'mappedHandle' => 'blockTitle',
                            'required' => true,
                            'width' => 75,
                        ],
                        [
                            'label' => 'Content',
                            'handle' => 'commonCkeditorDefault',
                            'mappedHandle' => 'blockContent',
                            'required' => true,
                            'width' => 100,
                        ],
                        [
                            'label' => 'Button',
                            'handle' => 'commonButton',
                            'mappedHandle' => 'blockButton',
                            'width' => 100,
                        ]
                    ],
                ]
            ]);

            $itemsMatrixField = new Matrix();
            $itemsMatrixField->name = 'Page Builder - Collapsible Content - Items';
            $itemsMatrixField->handle = 'pageBuilderCollapsibleContentItems';
            $itemsMatrixField->propagationMethod = PropagationMethod::None;
            $itemsMatrixField->minEntries = 1;
            $itemsMatrixField->viewMode = Matrix::VIEW_MODE_BLOCKS;
            $itemsMatrixField->createButtonLabel = 'Add item';
            $itemsMatrixField->setEntryTypes([$itemsEntryType]);
            Craft::$app->fields->saveField($itemsMatrixField);

            Plugin::getInstance()->pageBuilder->createBlock('Collapsible Content', 'collapsibleContentBlock', 'cube', [
                [
                    'name' => 'Content',
                    'fields' => [
                        [
                            'label' => 'Title Level',
                            'handle' => 'commonTitleLevel',
                            'mappedHandle' => 'blockTitleLevel',
                            'width' => 25,
                        ],
                        [
                            'label' => 'Title',
                            'handle' => 'commonCkeditorTitle',
                            'mappedHandle' => 'blockTitle',
                            'width' => 75,
                        ],
                        [
                            'label' => 'Content',
                            'handle' => 'commonCkeditorDefault',
                            'mappedHandle' => 'blockContent',
                            'width' => 100,
                        ],
                        [
                            'label' => 'Items',
                            'handle' => 'pageBuilderCollapsibleContentItems',
                            'mappedHandle' => 'blockItems',
                            'required' => true,
                            'width' => 100,
                        ],
                    ],
                ],
            ]);

            return true;
        } catch (Throwable $e) {
            Console::outputWarning($e);
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        try {
            $entries = Craft::$app->getEntries();

            $entryType = $entries->getEntryTypeByHandle('pageBuilderCollapsibleContentItems');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }

            $entryType = $entries->getEntryTypeByHandle('collapsibleContentBlock');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }

            $columnsMatrixField = Craft::$app->getFields()->getFieldByHandle('pageBuilderCollapsibleContentItems');
            if ($columnsMatrixField) {
                Craft::$app->fields->deleteField($columnsMatrixField);
            }


            return true;
        } catch (Throwable $e) {
            Console::outputWarning($e);
            return false;
        }
    }
}
