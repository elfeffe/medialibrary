---
name: medialibrary-development
description: Build and use the elfeffe/medialibrary package, including the MediaLibrary model, Filament resource integration, and Spatie Media Library workflows.
---

# Medialibrary Development

Use this skill when working on `elfeffe/medialibrary` or integrating the package into a Filament panel.

## Main package pieces

| Class / file | Purpose |
|---|---|
| `Models\MediaLibrary` | Central media model |
| `Resources\MediaLibraryResource` | Filament CRUD resource |
| `MedialibraryPlugin` | Registers the package resource in a panel |
| `MedialibraryServiceProvider` | Package bootstrap |

## Installation and registration

```php
->plugins([
    \Elfeffe\Medialibrary\MedialibraryPlugin::make(),
])
```

## Model behavior

`MediaLibrary`:
- Uses `InteractsWithMedia`
- Uses `Elfeffe\ImageResizer\Traits\HasImageResizer`
- Stores records in the `media_library` table
- Fills `uploaded_by_user_id` automatically on create when a user is authenticated

Typical usage:

```php
use Elfeffe\Medialibrary\Models\MediaLibrary;

$item = MediaLibrary::find(1);
$item->getItem('default');
$item->getMedia('default');
$item->getMediaHtml($item->getItem('default'), 800, 600, 'resize');
```

## Filament resource patterns

The package resource currently uses:
- `SpatieMediaLibraryFileUpload::make('media')`
- `TextInput::make('caption')`
- `TextInput::make('alt_text')`
- `SpatieMediaLibraryImageColumn::make('media')`

Navigation defaults:
- Group: `Media`
- Icon: `heroicon-o-photo`

## Best practices

- Prefer the package model/resource instead of building a parallel media table
- Use Spatie Media Library flows instead of custom upload pipelines
- Reuse `HasImageResizer` output helpers when the UI needs optimized media HTML or URLs
- Search Laravel, Filament, Spatie Media Library, and package docs before changing upload or resource syntax

## Tenant ownership (optional)

Set `MEDIALIBRARY_TENANT_MODEL=App\Models\Tenant` (or `medialibrary.tenant_model`) and publish/run the `add_tenant_id_to_medialibrary_table` migration. `MediaLibrary::tenant()` then resolves, so a Filament resource in a tenant panel can keep `$isScopedToTenant = true` with the default `tenant` ownership relationship. Leave the config null for single-tenant projects; the column stays nullable.
