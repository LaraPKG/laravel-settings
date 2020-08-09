<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaraPkg\Settings\Models\Setting as SettingModel;

class Setting
{
    /**
     * Gets a setting based on its key, group and entity
     *
     * @param string $search
     * @param int|null $entityId
     * @return mixed|null
     */
    public function get(string $search, int $entityId = null)
    {
        [$group, $key] = $this->parseKey($search);

        /** @var SettingModel|null $model */
        $model = $this->getModel($key, $group);

        return $model !== null
            ? $model->value($entityId)
            : null;
    }

    /**
     * Sets a setting to the given value
     * Returns the new value on update, or null on failure
     *
     * @param string $search
     * @param mixed $value
     * @param int|null $entityId
     * @return mixed|null
     */
    public function set(string $search, $value, int $entityId = null)
    {
        [$group, $key] = $this->parseKey($search);

        /** @var SettingModel|null $model */
        $model = $this->getModel($key, $group);

        return $model !== null
            ? $model->setValue($value, $entityId)
            : null;
    }

    /**
     * Gets all settings in a group
     *
     * @param string $group
     * @return Collection
     */
    public function group(string $group): Collection
    {
        return $this->getGroup($group)->get();
    }

    /**
     * Gets all settings
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getGroup()->get();
    }

    /**
     * Gets a settings model object based on criteria
     *
     * @param string $key
     * @param string|null $group
     * @return Model|null
     */
    protected function getModel(string $key, string $group = null): ?Model
    {
        /** @var SettingModel|null $setting */
        $setting = $this->getGroup($group)
            ->where('key', $key)
            ->first();

        return $setting;
    }

    /**
     * Gets an Eloquent builder scoped by a particular (optional) group
     *
     * @param string|null $group
     * @return Builder
     */
    protected function getGroup(string $group = null): Builder
    {
        /** @var SettingModel $model */
        $model = config('laravel-settings.model') ?? SettingModel::class;

        /** @var Builder $setting */
        $settings = $model::with(['group', 'values']);

        if ($group !== null) {
            $settings->forGroup($group);
        }

        return $settings;
    }

    /**
     * Parses a setting group, key combination using dot notation
     *
     * @param string $search
     * @return array
     */
    protected function parseKey(string $search): array
    {
        return strpos($search, '.') !== false
            ? explode('.', $search, 2)
            : [null, $search];
    }
}
