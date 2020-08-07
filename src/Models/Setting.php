<?php

declare(strict_types=1);

namespace LaraPkg\Settings\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Setting Model
 *
 * @package LaraPkg\Settings\Models
 *
 * @property string $name The setting name
 * @property string $description The setting description
 * @property int|null $group_id The settings group id
 * @property string $key The setting key
 * @property string $type The settings value type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection $values The setting values
 */
class Setting extends Model
{
    /**
     * The models attributes for mass assignment
     *
     * @var string[]
     */
    public $fillable = [
        'name',
        'description',
        'group_id',
        'key',
        'type',
    ];

    /**
     * A setting belongs to a setting group
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(SettingGroup::class);
    }

    /**
     * A setting has many values (based on entity id)
     *
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(SettingValue::class);
    }

    /**
     * Gets a setting value
     *
     * @param int|null $entityId
     * @return mixed
     */
    public function value(int $entityId = null)
    {
        return $this->castSettingValue(
            $this->values->where('entity_id', $entityId)
        );
    }

    /**
     * Sets the value of a setting to the provided data
     *
     * @param mixed $value
     * @param int|null $entityId
     * @return mixed
     */
    public function setValue($value, int $entityId = null)
    {
        $records = !$value instanceof \Illuminate\Support\Collection
            ? collect($value)
            : $value;

        $values = $this->storeValues($records, $entityId);

        return $this->castSettingValue(
            $values->count() < 2 ? $values->first() : $values
        );
    }

    /**
     * Stores setting values
     *
     * @param \Illuminate\Support\Collection $values
     * @param int|null $entityId
     * @return Collection
     */
    protected function storeValues(\Illuminate\Support\Collection $values, int $entityId = null): Collection
    {
        $this->values()->delete();

        return $this->values()->createMany(
            $values->map(static function ($item) use ($entityId) {
                return [
                    'entity_id' => $entityId,
                    'value' => $item,
                ];
            })
        );
    }

    /**
     * Cast a setting value to its native type
     *
     * @param Collection $values
     * @return mixed
     */
    protected function castSettingValue(Collection $values)
    {
        $cast = config("laravel-settings.casts.{$this->type}");
        $isArray = in_array($cast, ['array', 'json', 'collection']);

        if (!$isArray && $values->isEmpty()) {
            return null;
        }

        // Return multiple setting values as an array
        if ($isArray && $cast === 'collection') {
            return $values->pluck('value');
        }

        if ($isArray) {
            return $values->pluck('value')->toArray();
        }

        // Single value type
        switch ($cast) {
            case 'bool':
            case 'boolean':
                return filter_var($values->first()->value, FILTER_VALIDATE_BOOLEAN);
            case 'int':
                return (int)$values->first()->value;
            case 'float':
                return (float)$values->first()->value;
            case 'double':
                return (double)$values->first()->value;
            case 'string':
            default:
                return (string)$values->first()->value;
        }
    }
}
