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
                    $this->migrationPath('create_setting_groups_table'),
                    $this->migrationPath('create_settings_table'),
                    $this->migrationPath('create_setting_values_table')
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

        $this->app->singleton(Setting::class);
    }

    /**
     * Gets a database migration path to publish
     *
     * @param string $migration
     * @param null $order
     * @return array
     */
    protected function migrationPath(string $migration, $order = null): array
    {
        $key = __DIR__ . '/../database/migrations/' . $migration . '.php.stub';
        $timestamp = implode('_', array_filter([date('Y_m_d_Hi'), $order]));
        $value = database_path('migrations/' . $timestamp . '_' . $migration . '.php');

        return [$key => $value];
    }
}
