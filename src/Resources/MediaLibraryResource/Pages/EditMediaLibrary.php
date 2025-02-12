<?php

namespace Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages;

use Elfeffe\Medialibrary\Resources\MediaLibraryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaLibrary extends EditRecord
{
    protected static string $resource = MediaLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
