<?php

declare(strict_types=1);

namespace LaraPkg\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * SettingValue Model
 *
 * @package LaraPkg\Settings\Models
 *
 * @property int $setting_id The id of the related setting
 * @property int|null $entity_id The id of the entity the setting relates to (optional)
 */
class SettingValue extends Model
{
    /**
     * The models attributes for mass assignment
     *
     * @var string[]
     */
    public array $fillable = [
        'setting_id',
        'entity_id',
        'value',
    ];

    /**
     * A setting value belongs to a setting
     *
     * @return BelongsTo
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }
}
