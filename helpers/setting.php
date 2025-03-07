<?php

declare(strict_types=1);

use LaraPkg\Settings\Setting;

if (! function_exists('setting')) {
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
        /** @var Setting $manager */
        $manager = app(Setting::class);

        return $manager->get($key, $entityId);
    }
}

if (! function_exists('set_setting')) {
    /**
     * Helper to set a setting to new value(s)
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $entityId
     * @return mixed|null
     */
    function set_setting(string $key, $value, int $entityId = null)
    {
        /** @var Setting $manager */
        $manager = app(Setting::class);

        return $manager->set($key, $value, $entityId);
    }
}
