<?php

namespace App\Filament\Resources\AudioLibraryResource\Pages;

use App\Filament\Resources\AudioLibraryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudioLibrary extends EditRecord
{
    protected static string $resource = AudioLibraryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
