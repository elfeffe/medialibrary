<?php

namespace Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages;

use Elfeffe\Medialibrary\Resources\MediaLibraryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMediaLibraries extends ListRecords
{
    protected static string $resource = MediaLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
