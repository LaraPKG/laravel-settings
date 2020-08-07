<?php

declare(strict_types=1);

namespace LaraPkg\Settings\Tests;

use Illuminate\Foundation\Application;
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
}
