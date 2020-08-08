<?php

declare(strict_types=1);

/** @noinspection PhpIllegalPsrClassPathInspection */

namespace LaraPkg\Settings\Tests;

use Illuminate\Foundation\Application;
use LaraPkg\Settings\Models\Setting;
use LaraPkg\Settings\Models\SettingGroup;
use LaraPkg\Settings\SettingsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * The base TestCase
 *
 * @package LaraPkg\Settings\Tests
 */
class TestCase extends Orchestra
{
    /**
     * Setup factories for database
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/database/factories');
    }

    /**
     * Setup the environment for testing
     *
     * @param Application $app
     */
    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->runMigrations();
    }

    /**
     * Gets the service providers provided by the package
     *
     * @param Application $app
     * @return array|string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            SettingsServiceProvider::class,
        ];
    }

    /**
     * Run migrations manually by including the stub files
     */
    protected function runMigrations(): void
    {
        require_once __DIR__ . '/../database/migrations/create_setting_groups_table.php.stub';
        (new \CreateSettingGroupsTable())->up();

        require_once __DIR__ . '/../database/migrations/create_settings_table.php.stub';
        (new \CreateSettingsTable())->up();

        require_once __DIR__ . '/../database/migrations/create_setting_values_table.php.stub';
        (new \CreateSettingValuesTable())->up();
    }

    /**
     * Gets data for creating a new setting via mass assignment
     *
     * @param string $key
     * @param string $name
     * @param string $type
     * @param int|null $groupId
     * @return Setting|null
     */
    protected function createSetting(string $key, string $name, string $type, int $groupId = null): ?Setting
    {
        return Setting::create([
            'name' => $name,
            'group_id' => $groupId,
            'key' => $key,
            'type' => $type,
        ]);
    }
}
