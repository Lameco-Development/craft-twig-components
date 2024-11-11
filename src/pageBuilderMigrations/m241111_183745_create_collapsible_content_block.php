<?php

namespace lameco\crafttwigcomponents\pageBuilderMigrations;

use Craft;
use craft\db\Migration;
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
            Plugin::getInstance()->pageBuilder->createBlock('Collapsible Content', 'collapsibleContentBlock', [
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
                            'handle' => 'commonCKEditorAdvanced',
                            'mappedHandle' => 'blockContent',
                            'required' => true,
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
            Console::outputWarning($e->getMessage());
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
            $entryType = $entries->getEntryTypeByHandle('collapsibleContentBlock');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }

            return true;
        } catch (Throwable $e) {
            Console::outputWarning($e->getMessage());
            return false;
        }
    }
}
