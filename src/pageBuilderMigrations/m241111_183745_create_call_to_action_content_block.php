<?php

namespace lameco\crafttwigcomponents\pageBuilderMigrations;

use Craft;
use craft\db\Migration;
use craft\enums\PropagationMethod;
use craft\fields\Matrix;
use craft\helpers\Console;
use lameco\crafttwigcomponents\Plugin;
use Throwable;

/**
 * m241111_183745_create_call_to_action_content_block migration.
 */class m241111_183745_create_call_to_action_content_block extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        try {
            Plugin::getInstance()->pageBuilder->createBlock('Call To Action', 'callToActionBlock', 'cube', [
                [
                    'name' => 'Content',
                    'fields' => [
                        [
                            'label' => 'Text Alignment',
                            'handle' => 'commonTextAlignment',
                            'mappedHandle' => 'blockTextAlignment',
                            'width' => 50,
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

            $entryType = $entries->getEntryTypeByHandle('callToActionBlock');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }


            return true;
        } catch (Throwable $e) {
            Console::outputWarning($e);
            return false;
        }
    }
}
