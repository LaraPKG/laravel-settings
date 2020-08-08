<?php

declare(strict_types=1);

/** @noinspection PhpIllegalPsrClassPathInspection */

namespace LaraPkg\Settings\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use LaraPkg\Settings\Models\Setting;

class ValueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_settings_with_configured_types(): void
    {
        $types = config('laravel-settings.types') ?? ['string'];
        $settings = $this->createSettingsForDefinedTypes();

        foreach (array_combine($types, $settings) as $type => $setting) {
            $this->assertSame($type, $setting->type);
        }
    }

    /** @test */
    public function can_retrieve_settings_with_their_castable_types(): void
    {
        $types = config('laravel-settings.types') ?? ['string'];
        $settings = $this->createSettingsForDefinedTypes();

        foreach (array_combine($types, $settings) as $type => $setting) {
            $cast = config("laravel-settings.casts.$type") ?? 'string';
            $this->createMockValueForType($setting, $type);

            $value = $setting->value();

            $this->assertThatValueIsOfType($cast, $value);
        }
    }

    /**
     * Creates a mock setting value depending on type
     *
     * @param Setting $setting
     * @param string $type
     */
    protected function createMockValueForType(Setting $setting, string $type): void
    {
        $cast = config("laravel-settings.casts.$type");
        $isArray = in_array($cast, ['array', 'json', 'collection']);

        // Return multiple setting values as an array
        if ($isArray && $cast === 'collection') {
            $setting->setValue(collect(['some', 'dummy', 'data']));

            return;
        }

        if ($isArray) {
            $setting->setValue(['some', 'dummy', 'data']);

            return;
        }

        // Single value type
        switch ($cast) {
            case 'bool':
            case 'boolean':
                $setting->setValue(true);

                return;
            case 'int':
                $setting->setValue(123);

                return;
            case 'double':
            case 'float':
                $setting->setValue(23.12);

                return;
        }

        $setting->setValue('hello world');
    }

    /**
     * Performs an assertion to ensure that the given value is of the correct native type
     *
     * @param string $cast
     * @param mixed $value
     */
    protected function assertThatValueIsOfType(string $cast, $value): void
    {
        $isArray = in_array($cast, ['array', 'json', 'collection']);

        // Return multiple setting values as an array
        if ($isArray && $cast === 'collection') {
            $this->assertInstanceOf(Collection::class, $value);

            return;
        }

        if ($isArray) {
            $this->assertIsArray($value);

            return;
        }

        // Single value type
        switch ($cast) {
            case 'bool':
            case 'boolean':
                $this->assertIsBool($value);

                return;
            case 'int':
                $this->assertIsInt($value);

                return;
            case 'double':
            case 'float':
                $this->assertIsFloat($value);

                return;
        }

        $this->assertIsString($value);
    }

    /**
     * Creates a setting for each type defined in the config
     *
     * @return array
     */
    protected function createSettingsForDefinedTypes(): array
    {
        $types = config('laravel-settings.types') ?? ['string'];
        $settings = [];

        foreach ($types as $type) {
            $settings[] = $this->createSetting('test', 'Test', $type);
        }

        return $settings;
    }
}
