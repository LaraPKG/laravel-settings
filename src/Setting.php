<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use LaraPkg\Settings\Models\Setting as SettingModel;

class Setting
{
    /**
     * Gets a setting based on its key, group and entity
     *
     * @param string $key
     * @param string|null $group
     * @param int|null $entityId
     * @return mixed|null
     */
    public function get(string $key, string $group = null, int $entityId = null)
    {
        $model = $this->getModel($key, $group);

        return $model !== null
            ? $model->value($entityId)
            : null;
    }

    /**
     * Sets a setting to the given value
     * Returns the new value on update, or null on failure
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $group
     * @param int|null $entityId
     * @return mixed|null
     */
    public function set(string $key, $value, string $group = null, int $entityId = null)
    {
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
        $model = config('laravel-settings.model') ?: SettingModel::class;

        /** @var SettingModel $setting */
        $setting = $model::with('values')
            ->where('group_id', $group)
            ->where('key', $key)
            ->first();

        return $setting;
    }
}
