<?php

namespace lameco\crafttwigcomponents\settingsMigrations;

use Craft;
use craft\db\Migration;
use craft\helpers\Console;
use Exception;
use lameco\crafttwigcomponents\Plugin;
use Throwable;

/**
 * m241111_183745_collapsible_content_block_update_settings migration.
 */
class m241111_183745_collapsible_content_block_update_settings extends Migration
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function safeUp(): bool
    {
        return Plugin::getInstance()->pageBuilder->addBlockToSettingsModel([
            'name' => 'Collapsible Content',
            'enabled' => false,
            'migration' => 'm241111_183745_create_collapsible_content_block'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        return true;
    }
}
