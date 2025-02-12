<?php

namespace Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages;

use Elfeffe\Medialibrary\Resources\MediaLibraryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMediaLibraries extends ListRecords
{
    protected static string $resource = MediaLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
