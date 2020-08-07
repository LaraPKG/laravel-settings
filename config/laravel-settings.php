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
     * The model to use
     */
    'model' => \LaraPkg\Settings\Models\Setting::class,
];
