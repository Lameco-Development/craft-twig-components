<?php

namespace lameco\crafttwigcomponents\migrations;

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
                    'label' => 'Pre-title',
                    'handle' => 'commonCkeditorTitle',
                    'mappedHandle' => 'blockPreTitle'
                ],
                [
                    'label' => 'Title Level',
                    'handle' => 'commonTitleLevel',
                    'mappedHandle' => 'blockTitleLevel'
                ],
                [
                    'label' => 'Title',
                    'handle' => 'commonCkeditorTitle',
                    'mappedHandle' => 'blockTitle'
                ],
                [
                    'label' => 'Intro',
                    'handle' => 'commonCkeditorDefault',
                    'mappedHandle' => 'blockIntro'
                ],
                [
                    'label' => 'Content',
                    'handle' => 'commonCkeditorDefault',
                    'mappedHandle' => 'blockContent'
                ],
                [
                    'label' => 'Button',
                    'handle' => 'commonButton',
                    'mappedHandle' => 'blockButton'
                ],
                [
                    'label' => 'Alignment',
                    'handle' => 'commonAlignment',
                    'mappedHandle' => 'blockAlignment'
                ],
                [
                    'label' => 'Image',
                    'handle' => 'commonImage',
                    'mappedHandle' => 'blockImage'
                ],
                [
                    'label' => 'Video',
                    'handle' => 'commonVideo',
                    'mappedHandle' => 'blockVideo'
                ],
            ]);
        } catch (Throwable $e) {
            Console::outputWarning($e->getMessage());
            return false;
        }

        return true;
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
