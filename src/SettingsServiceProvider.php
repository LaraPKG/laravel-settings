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
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . '/../config/laravel-settings.php' => config_path('laravel-settings.php')],
                'config'
            );
        }
    }

    /**
     * Register services provided by the provider
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-settings.php', 'laravel-settings');
    }
}
