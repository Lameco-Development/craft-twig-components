<?php

namespace lameco\crafttwigcomponents\settingsMigrations;

use craft\db\Migration;
use Exception;
use lameco\crafttwigcomponents\Plugin;

/**
 * m241111_183745_call_to_action_content_block_update_settings migration.
 */
class m241111_183745_call_to_action_content_block_update_settings extends Migration
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function safeUp(): bool
    {
        return Plugin::getInstance()->pageBuilder->addBlockToSettingsModel([
            'name' => 'Call To Action',
            'enabled' => false,
            'migration' => 'm241111_183745_create_call_to_action_content_block'
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
