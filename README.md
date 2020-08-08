<p align="center">
    <img src="logo.svg" alt="LaraPKG Laravel Settings">
    <br>
    <br>
    <img src="https://github.com/LaraPKG/laravel-settings/workflows/Tests/badge.svg" alt="PHP Unit Tests">
    <img src="https://github.com/LaraPKG/laravel-settings/workflows/Psalm/badge.svg" alt="Psalm">
    <img src="https://github.com/LaraPKG/laravel-settings/workflows/PHP%20CS%20Fixer/badge.svg" alt="PHP CS Fixer">
</p>

Adds **simple** settings to any Laravel application.

### Usage

#### Types

Define setting types in `config/laravel-settings.php`, these are simply stored along with each setting.

#### Casts

Define type casts in the above config file, setting values will automatically be casted to their native types on retrieval!
```php
return [
    // ...
    'casts' => [
        'boolean' => 'bool',
        'select' => 'array',
        'json' => 'json',
        'number' => 'int',
    ],
    // ...
];
```

#### Retrieving a setting value

- Using the helper
```php
setting('setting_group.key');
```

- Using the facade
```php
\LaraPkg\Settings\Facades\Setting::get('setting_group.key');
```

- With an Entity id
An entity id allows you to store specific settings for that entity (such as a Domain or multi-tenant application)
```php
$entityId = 1;
\LaraPkg\Settings\Facades\Setting::get('setting_group.key', $entityId);
```

#### Setting a setting

- Using the helper
```php
set_setting('setting_group.key', 'Some value!');
```

- Using the Facade
```php
$value = 'something to store';
$entityId = 1 ?? null;
$groupName = 'setting_group' ?? null;
\LaraPkg\Settings\Facades\Setting::set('key', $value, $groupName, $entityId);
```

### Installation

```shell script
composer require larapkg/laravel-settings
```

```shell script
php artisan vendor:publish --provider="LaraPkg\Settings\SettingsServiceProvider"
```
