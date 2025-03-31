<?php

namespace Elfeffe\Medialibrary\Resources;

use Elfeffe\Medialibrary\Models\MediaLibrary;
use Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages\CreateMediaLibrary;
use Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages\EditMediaLibrary;
use Elfeffe\Medialibrary\Resources\MediaLibraryResource\Pages\ListMediaLibraries;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class MediaLibraryResource extends Resource
{
    protected static ?string $model = MediaLibrary::class;

    protected static ?string $navigationGroup = 'Media';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                    ->columnSpan(2)
                    ->image()
                    ->disk('medialibrary'),
                Forms\Components\TextInput::make('caption'),
                Forms\Components\TextInput::make('alt_text'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('media.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('media')
                    ->disk('medialibrary')
                    ->square()
                    ->size(200),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMediaLibraries::route('/'),
            'create' => CreateMediaLibrary::route('/create'),
            'edit' => EditMediaLibrary::route('/{record}/edit'),
        ];
    }
}
