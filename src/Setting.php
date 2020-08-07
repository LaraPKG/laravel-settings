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
        $setting = SettingModel::with('values')
            ->where('group_id', $group)
            ->where('key', $key);

        if ($setting === null) {
            return null;
        }

        return $setting->value($entityId);
    }
}
