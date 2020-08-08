<p align="center">
    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTc2IiBoZWlnaHQ9IjgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgPGc+CiAgICAgICAgPHJlY3QgZmlsbD0iI2ZmZiIgaWQ9ImNhbnZhc19iYWNrZ3JvdW5kIiBoZWlnaHQ9IjgyIiB3aWR0aD0iMTc4IiB5PSItMSIgeD0iLTEiLz4KICAgICAgICA8ZyBkaXNwbGF5PSJub25lIiBvdmVyZmxvdz0idmlzaWJsZSIgeT0iMCIgeD0iMCIgaGVpZ2h0PSIxMDAlIiB3aWR0aD0iMTAwJSIgaWQ9ImNhbnZhc0dyaWQiPgogICAgICAgICAgICA8cmVjdCBmaWxsPSJ1cmwoI2dyaWRwYXR0ZXJuKSIgc3Ryb2tlLXdpZHRoPSIwIiB5PSIwIiB4PSIwIiBoZWlnaHQ9IjEwMCUiIHdpZHRoPSIxMDAlIi8+CiAgICAgICAgPC9nPgogICAgPC9nPgogICAgPGc+CiAgICAgICAgPHRleHQgZm9udC13ZWlnaHQ9Im5vcm1hbCIgZm9udC1zdHlsZT0ibm9ybWFsIiB4bWw6c3BhY2U9InByZXNlcnZlIiB0ZXh0LWFuY2hvcj0ic3RhcnQiCiAgICAgICAgICAgICAgZm9udC1mYW1pbHk9IkhlbHZldGljYSwgQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMzIiIGlkPSJzdmdfMSIgeT0iMzAuNDUwMDEiIHg9IjIwLjUiCiAgICAgICAgICAgICAgc3Ryb2tlLXdpZHRoPSIwIiBzdHJva2U9IiMwMDAiIGZpbGw9IiMwOTQ5YjciPkxhcmFQS0c8L3RleHQ+CiAgICAgICAgPHRleHQgZm9udC13ZWlnaHQ9Im5vcm1hbCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgdGV4dC1hbmNob3I9InN0YXJ0IiBmb250LWZhbWlseT0iSGVsdmV0aWNhLCBBcmlhbCwgc2Fucy1zZXJpZiIKICAgICAgICAgICAgICBmb250LXNpemU9IjI0IiBpZD0ic3ZnXzIiIHk9IjY4LjQ1MDAxIiB4PSIyLjUiIHN0cm9rZS13aWR0aD0iMCIgc3Ryb2tlPSIjMDAwIiBmaWxsPSIjNDc0NzQ3Ij5MYXJhdmVsIFNldHRpbmdzPC90ZXh0PgogICAgPC9nPgo8L3N2Zz4=" alt="LaraPKG Laravel Settings">    
</p>

# LaraPKG
## Laravel Settings

![PHPUnit](https://github.com/LaraPKG/laravel-settings/workflows/Tests/badge.svg)
![Psalm](https://github.com/LaraPKG/laravel-settings/workflows/Psalm/badge.svg)
![PHPCS](https://github.com/LaraPKG/laravel-settings/workflows/PHP%20CS%20Fixer/badge.svg)

Adds **simple** settings to any Laravel application.

### Usage

#### Retrieving a setting

- Using the helper
```php
setting('setting_group.key');
```

- Using the facade
```php
\LaraPkg\Settings\Facades\Setting::get('key', 'setting_group');
```

#### Setting a setting

- Using the helper
```php
set_setting('setting_group.key', 'Some value!');
```

- Using the Facade
```php
$value = 'something to store';
\LaraPkg\Settings\Facades\Setting::set('key', $value, 'setting_group');
```

### Installation

```shell script
composer require larapkg/laravel-settings
```
