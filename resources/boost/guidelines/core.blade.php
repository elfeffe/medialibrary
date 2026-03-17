## Medialibrary

This package provides a centralized media library built on top of Spatie Media Library, with Filament resource integration for uploading and managing media.

### Use the package primitives

- Use `Elfeffe\Medialibrary\Models\MediaLibrary` as the central media model.
- Prefer Spatie Media Library flows and the package model/resource over custom upload tables or custom media managers.
- Use `Elfeffe\Medialibrary\MedialibraryPlugin` when exposing the package in Filament.

@verbatim
<code-snippet name="Use the MediaLibrary model" lang="php">
use Elfeffe\Medialibrary\Models\MediaLibrary;

$item = MediaLibrary::find(1);
$item->getItem('default');
$item->getMedia('default');
</code-snippet>
@endverbatim

### Filament

- Reuse `MediaLibraryResource` for centralized media management.
- Prefer package and Spatie media upload components instead of custom uploaders.
- Keep media behavior in the model/resource layer, not in Blade templates.

@verbatim
<code-snippet name="Register the Filament plugin" lang="php">
->plugins([
    \Elfeffe\Medialibrary\MedialibraryPlugin::make(),
])
</code-snippet>
@endverbatim

### Best practices

- Use Spatie Media Library APIs for storage and retrieval.
- Reuse package resource patterns for admin management.
- Avoid custom upload pipelines when package + Spatie features already cover the use case.
