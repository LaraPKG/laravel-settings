<?php

declare(strict_types=1);

/** @noinspection PhpIllegalPsrClassPathInspection */

namespace LaraPkg\Settings\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraPkg\Settings\Facades\Setting;
use LaraPkg\Settings\Models\SettingGroup;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_read_a_setting_in_a_group(): void
    {
        // Create a dummy setting group
        $group = SettingGroup::create(['name' => 'my_group']);
        $setting = $this->createSetting('grouped_setting', 'Grouped Setting', 'text', $group->id);

        // Set the setting to a dummy value
        $setting->setValue('test');

        // Get the value using the Facade
        $this->assertEquals('test', Setting::value('my_group.grouped_setting'));
    }

    /** @test */
    public function can_read_a_setting_not_in_a_group(): void
    {
        $setting = $this->createSetting('test_setting', 'Ungrouped Setting', 'text');

        $setting->setValue('test');
        $this->assertEquals('test', Setting::value('test_setting'));
    }

    /** @test */
    public function can_read_a_setting_with_an_entity_id(): void
    {
        $setting = $this->createSetting('test_setting', 'Entity Setting', 'text');

        // Non entity value
        $setting->setValue('test');
        $this->assertEquals('test', Setting::value('test_setting'));

        // Entity value
        $setting->setValue('for_entity', 1);
        $this->assertEquals('for_entity', Setting::value('test_setting', 1));
    }
}
