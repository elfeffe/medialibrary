<?php

namespace Elfeffe\Medialibrary;

use Elfeffe\Medialibrary\Resources\MediaLibraryResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class MedialibraryPlugin implements Plugin
{
    public function getId(): string
    {
        return 'media-library';
    }

    public function register(Panel $panel): void
    {
        // Register your Filament resources, pages, widgets, etc.:
        $panel
            ->resources([
                MediaLibraryResource::class,
            ])
        ;
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
