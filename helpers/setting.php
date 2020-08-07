<?php

declare(strict_types=1);

use LaraPkg\Settings\Setting;

if (!function_exists('setting')) {
    /**
     * Helper to retrieve a setting based on its key
     * Use dot notation to specify the setting group
     * Example: my_group.my_key
     *
     * @param string $key
     * @param int|null $entityId
     * @return mixed|null
     */
    function setting(string $key, int $entityId = null)
    {
        [$group, $setting] = strpos($key, '.') !== false
            ? explode('.', $key, 1)
            : [null, $key];

        /** @var Setting $manager */
        $manager = app(Setting::class);

        return $manager->get($setting, $group, $entityId);
    }
}
