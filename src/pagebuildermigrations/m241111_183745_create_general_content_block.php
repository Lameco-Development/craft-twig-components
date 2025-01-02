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
 * m241111_183745_create_general_content_block migration.
 */
class m241111_183745_create_general_content_block extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        try {
            $columnsEntryType = Plugin::getInstance()->entryHelper->createEntryType('Page Builder - General Content - Columns', 'pageBuilderGeneralContentColumns', 'cubes', true, [
                [
                    'name' => 'Content',
                    'fields' => [
                        [
                            'label' => 'Pre-title',
                            'handle' => 'commonCkeditorTitle',
                            'mappedHandle' => 'blockPreTitle',
                        ],
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
                            'required' => true,
                            'width' => 100,
                        ],
                        [
                            'label' => 'Buttons',
                            'handle' => 'commonButtons',
                            'mappedHandle' => 'blockButtons',
                            'width' => 100,
                        ]

                    ],
                ]
            ]);

            $columnsMatrixField = new Matrix();
            $columnsMatrixField->name = 'Page Builder - General Content - Columns';
            $columnsMatrixField->handle = 'pageBuilderGeneralContentColumns';
            $columnsMatrixField->propagationMethod = PropagationMethod::None;
            $columnsMatrixField->minEntries = 1;
            $columnsMatrixField->viewMode = Matrix::VIEW_MODE_BLOCKS;
            $columnsMatrixField->createButtonLabel = 'Add column';
            $columnsMatrixField->setEntryTypes([$columnsEntryType]);
            Craft::$app->fields->saveField($columnsMatrixField);

            Plugin::getInstance()->pageBuilder->createBlock('General Content', 'generalContentBlock', 'cube', [
                [
                    'name' => 'Content',
                    'fields' => [
                        [
                            'label' => 'Column Alignment',
                            'handle' => 'commonTextAlignment',
                            'mappedHandle' => 'blockColumnsAlignment',
                            'width' => 50,
                        ],
                        [
                            'label' => 'Text Alignment',
                            'handle' => 'commonTextAlignment',
                            'mappedHandle' => 'blockTextAlignment',
                            'width' => 50,
                        ],
                        [
                            'class' => Matrix::class,
                            'entryTypes' => [$columnsEntryType->id],
                            'label' => 'Columns',
                            'handle' => 'pageBuilderGeneralContentColumns',
                            'mappedHandle' => 'blockColumns',
                            'required' => true,
                            'width' => 100,
                        ],
                    ],
                ]
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

            $entryType = $entries->getEntryTypeByHandle('pageBuilderGeneralContentColumns');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }

            $entryType = $entries->getEntryTypeByHandle('generalContentBlock');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }

            $columnsMatrixField = Craft::$app->getFields()->getFieldByHandle('pageBuilderGeneralContentColumns');
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
