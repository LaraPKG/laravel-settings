<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use Illuminate\Support\Facades\Facade;

/**
 * Setting Facade
 *
 * @package LaraPkg\Settings
 * @see Setting
 *
 * @method static get(string $key, string $group = null, int $entityId = null)
 */
class SettingFacade extends Facade
{
    /**
     * Gets the Facade Accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'setting';
    }
}
