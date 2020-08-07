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

            if (!class_exists('CreatePackageTable')) {
                $this->publishes([
                    $this->migrationPath('create_setting_groups_table'),
                    $this->migrationPath('create_settings_table'),
                    $this->migrationPath('create_setting_values_table'),
                ]);
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
     * @return array
     */
    protected function migrationPath(string $migration): array
    {
        $key = __DIR__ . '/../database/migrations/' . $migration . '.php.stub';
        $value = database_path('migrations/' . date('Y_m_d_His') . '_' . $migration . '.php');

        return [$key => $value];
    }
}
