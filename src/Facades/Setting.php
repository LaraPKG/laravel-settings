<?php

declare(strict_types=1);

namespace LaraPkg\Settings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Setting Facade
 *
 * @package LaraPkg\Settings
 * @see \LaraPkg\Settings\Setting
 *
 * @method static get(string $key, int $entityId = null)
 * @method static set(string $key, mixed $value, int $entityId = null)
 */
class Setting extends Facade
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
