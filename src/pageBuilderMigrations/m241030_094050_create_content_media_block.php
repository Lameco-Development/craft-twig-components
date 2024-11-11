<?php

namespace lameco\crafttwigcomponents\pageBuilderMigrations;

use Craft;
use craft\db\Migration;
use craft\helpers\Console;
use lameco\crafttwigcomponents\Plugin;
use Throwable;

/**
 * m241030_094050_create_content_media_block migration.
 */
class m241030_094050_create_content_media_block extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        try {
            Plugin::getInstance()->pageBuilder->createBlock('Content Media', 'contentMediaBlock', [
                [
                    'name' => 'Media',
                    'fields' => [
                        [
                            'label' => 'Image',
                            'handle' => 'commonImage',
                            'mappedHandle' => 'blockImage',
                            'required' => true,
                            'width' => 50,
                        ],
                        [
                            'label' => 'Video',
                            'handle' => 'commonVideo',
                            'mappedHandle' => 'blockVideo',
                            'width' => 50,
                        ],
                        [
                            'label' => 'Alignment',
                            'handle' => 'commonAlignment',
                            'mappedHandle' => 'blockAlignment',
                            'width' => 100,
                        ],
                    ],
                ],
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
                            'label' => 'Intro',
                            'handle' => 'commonCKEditorSimple',
                            'mappedHandle' => 'blockIntro',
                            'width' => 100,
                        ],
                        [
                            'label' => 'Content',
                            'handle' => 'commonCKEditorAdvanced',
                            'mappedHandle' => 'blockContent',
                            'required' => true,
                            'width' => 100,
                        ],
                        [
                            'label' => 'Buttons',
                            'handle' => 'commonButton',
                            'mappedHandle' => 'blockButton',
                            'width' => 100,
                        ],
                    ]],
            ]);

            return true;
        } catch (Throwable $e) {
            Console::outputWarning($e->getMessage());
            return false;
        }
    }

    /**
     * @inheritdoc
     * @throws Throwable
     */
    public function safeDown(): bool
    {
        try {
            $entries = Craft::$app->getEntries();
            $entryType = $entries->getEntryTypeByHandle('contentMediaBlock');
            if ($entryType) {
                $entries->deleteEntryType($entryType);
            }
        } catch (Throwable $e) {
            Console::outputWarning($e->getMessage());
            return false;
        }

        return true;
    }
}
