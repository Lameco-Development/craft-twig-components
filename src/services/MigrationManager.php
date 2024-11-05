<?php

namespace lameco\crafttwigcomponents\services;

use Craft;
use craft\errors\MigrationException;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Migration Manager service
 */
class MigrationManager extends Component
{
    /**
     * @throws \Throwable
     * @throws InvalidConfigException
     * @throws MigrationException
     */
    public function migrateComponent(string $migrationName, bool $up = false): void
    {
        $migrationClass = "lameco\\crafttwigcomponents\\migrations\\$migrationName";

        if (class_exists($migrationClass)) {
            $migration = new $migrationClass();
        } else {
            throw new \Exception("Migration class $migrationClass does not exist.");
        }

        $migrator = Craft::$app->getMigrator();

        try {
            $hasRun = $migrator->hasRun($migrationName);

            if ($up && !$hasRun){
                $migrator->migrateUp($migration);
            }
            elseif(!$up && $hasRun){
                $migrator->migrateDown($migration);
            }
        } catch (\Throwable $e) {
            Craft::error("Migration failed: {$e->getMessage()}", __METHOD__);
            throw $e;
        }
    }
}
