<?php

namespace App\Filament\Resources\AudiobookEpisodeResource\Pages;

use App\Filament\Resources\AudiobookEpisodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudiobookEpisodes extends ListRecords
{
    protected static string $resource = AudiobookEpisodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
