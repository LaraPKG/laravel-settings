<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

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

        $model = $this->getModel($key, $group);

        return $model !== null
            ? $model->setValue($value, $entityId)
            : null;
    }

    /**
     * Gets a settings model object based on criteria
     *
     * @param string $key
     * @param string|null $group
     * @return SettingModel|null
     */
    protected function getModel(string $key, string $group = null): ?SettingModel
    {
        /** @var SettingModel $model */
        $model = config('laravel-settings.model') ?: SettingModel::class;

        /** @var SettingModel $setting */
        $setting = $model::with(['group', 'values']);

        if ($group !== null) {
            $setting->forGroup($group);
        }

        return $setting->where('key', $key)->first();
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
