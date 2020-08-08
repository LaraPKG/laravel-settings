<?php

declare(strict_types=1);

namespace LaraPkg\Settings;

use Illuminate\Database\Eloquent\Builder;
use LaraPkg\Settings\Models\Setting as SettingModel;
use LaraPkg\Settings\Models\SettingGroup;

class Setting
{
    /**
     * Gets a setting value by its group_name.setting_key
     *
     * @param string $search
     * @param int|null $entityId
     * @return mixed|null
     */
    public function value(string $search, int $entityId = null)
    {
        [$group, $key] = $this->parseKey($search);

        $model = $this->getModel($key, $group);

        return $model !== null
            ? $model->value($entityId)
            : null;
    }

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
        /** @var SettingModel $model */
        $model = config('laravel-settings.model') ?: SettingModel::class;

        /** @var SettingModel $setting */
        $setting = $model::with(['group', 'values']);

        return $setting->forGroup($group)->where('key', $key)->first();
    }

    /**
     * Creates a new setting for the given group
     *
     * @param string $key
     * @param string|null $group
     * @return SettingModel|null
     */
    protected function createModel(string $key, string $group = null): ?SettingModel
    {
        /** @var SettingModel $model */
        $model = config('laravel-settings.model') ?: SettingModel::class;
        $groupId = null;

        if ($group !== null) {
            $groupModel = SettingGroup::firstOrCreate(['name' => $group]);
            $groupId = $groupModel !== null ? $groupModel->id : null;
        }

        /** @var SettingModel|null $setting */
        $setting = $model::create([
            'group_id' => $groupId,
            'key' => $key,
        ]);

        return $setting;
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
