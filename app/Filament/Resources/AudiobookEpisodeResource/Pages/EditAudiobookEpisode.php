<?php

namespace App\Filament\Resources\AudiobookEpisodeResource\Pages;

use App\Filament\Resources\AudiobookEpisodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudiobookEpisode extends EditRecord
{
    protected static string $resource = AudiobookEpisodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
