<?php

declare(strict_types=1);

namespace LaraPkg\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * SettingGroup Model
 *
 * @package LaraPkg\Settings\Models
 *
 * @property int $id The group id
 * @property string $name The setting group name
 * @property string $description The setting groups description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SettingGroup extends Model
{
    /**
     * The models attributes for mass assignment
     *
     * @var string[]
     */
    public $fillable = [
        'name',
        'description',
    ];

    /**
     * A setting group has many settings
     *
     * @return HasMany
     */
    public function settings(): HasMany
    {
        /** @var class-string<Model>|null $model */
        $model = config('laravel-settings.model');

        return $this->hasMany($model ?? Setting::class);
    }
}
