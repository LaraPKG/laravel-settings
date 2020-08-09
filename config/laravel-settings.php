<?php

declare(strict_types=1);

return [
    /**
     * The allowed setting types
     */
    'types' => [
        'string',
        'text',
        'boolean',
        'select',
        'json',
        'number',
    ],

    /**
     * Casts setting values to native types based on field type
     */
    'casts' => [
        'boolean' => 'bool',
        'select' => 'array',
        'json' => 'json',
        'number' => 'int',
    ],

    /**
     * The model to use for the settings table
     */
    'model' => \LaraPkg\Settings\Models\Setting::class,

    /**
     * The model to use for the setting groups table
     */
    'group_model' => \LaraPkg\Settings\Models\SettingGroup::class,

    /**
     * The model to use for the setting values table
     */
    'value_model' => \LaraPkg\Settings\Models\SettingValue::class,
];
