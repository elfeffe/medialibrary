<?php

// config for Elfeffe/Medialibrary
return [
    // Fully-qualified tenant model for Filament tenant scoping, or null to disable.
    'tenant_model' => env('MEDIALIBRARY_TENANT_MODEL'),

    // Disk the resource stores files on. An app that already has an object-storage disk
    // (e.g. Pixany's `pixany`) points this at it; the default stays the local public disk below.
    'disk' => env('MEDIALIBRARY_DISK', 'medialibrary'),
];
