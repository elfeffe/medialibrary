---
name: medialibrary-development
description: Build and use the elfeffe/medialibrary package, including the MediaLibrary model, Filament resource integration, and Spatie Media Library workflows. Use when working with centralized media management, media uploads, media browsing, or the medialibrary package.
---

# Medialibrary Development

Use this skill when working on `elfeffe/medialibrary` or integrating its media library into Filament.

## Boost discovery

- Third-party Boost skills are discovered from `resources/boost/skills/{skill-name}/SKILL.md`.
- After installing `elfeffe/medialibrary`, users can run `php artisan boost:install` to have Boost discover this package skill.
- Use `php artisan boost:update` after package updates if Boost resources need refreshing.

## Installation

```bash
composer require elfeffe/medialibrary
php artisan boost:install
```

Register the Filament plugin:

```php
->plugins([
    \Elfeffe\Medialibrary\MedialibraryPlugin::make(),
])
```

## Main pieces

| Class / Symbol | Purpose |
|---|---|
| `Models\MediaLibrary` | Central media model |
| `Resources\MediaLibraryResource` | Filament CRUD resource |
| `MedialibraryPlugin` | Filament plugin |
| `MedialibraryServiceProvider` | Auto-discovered service provider |

## Core usage

```php
use Elfeffe\Medialibrary\Models\MediaLibrary;

$item = MediaLibrary::find(1);
$item->getItem('default');
$item->getMedia('default');
```

## Filament usage

Use the package resource/plugin for centralized admin management, and prefer Spatie Media Library fields when integrating uploads.

## Best practices

- Use Spatie Media Library flows instead of custom upload handling.
- Keep media management inside the package resource/plugin when possible.
- Reuse the model methods and existing Filament resource patterns.
- Search Laravel / Filament docs with Boost before guessing syntax around uploads, media fields, and resources.
