<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use Illuminate\Support\Facades\Facade;

/**
 * Setting Facade
 *
 * @package LaraPkg\Settings
 * @mixin Setting
 * @see Setting
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
