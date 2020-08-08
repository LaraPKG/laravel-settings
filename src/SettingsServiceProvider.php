<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use Illuminate\Support\ServiceProvider;

/**
 * Settings Service Provider
 *
 * @package LaraPkg\Settings
 */
class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Boots the service provider
     */
    public function boot(): void
    {
        // Publish package assets
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . '/../config/laravel-settings.php' => config_path('laravel-settings.php')],
                'config'
            );

            if (! class_exists('CreatePackageTable')) {
                $this->publishes(array_merge(
                    $this->migrationPath('create_setting_groups_table', 1),
                    $this->migrationPath('create_settings_table', 2),
                    $this->migrationPath('create_setting_values_table', 3)
                ), 'migrations');
            }
        }
    }

    /**
     * Register services provided by the provider
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-settings.php', 'laravel-settings');

        $this->app->singleton('setting', Setting::class);
    }

    /**
     * Gets a database migration path to publish
     *
     * @param string $migration
     * @param int|null $order
     * @return array
     */
    protected function migrationPath(string $migration, int $order = null): array
    {
        $key = __DIR__ . '/../database/migrations/' . $migration . '.php.stub';
        $timestamp = date('Y_m_d_Hi') . str_pad((string)$order, 2, '0', STR_PAD_LEFT);
        $value = database_path('migrations/' . $timestamp . '_' . $migration . '.php');

        return [$key => $value];
    }
}
