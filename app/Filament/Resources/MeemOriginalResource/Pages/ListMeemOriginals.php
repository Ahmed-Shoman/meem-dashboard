<?php

namespace App\Filament\Resources\MeemOriginalResource\Pages;

use App\Filament\Resources\MeemOriginalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeemOriginals extends ListRecords
{
    protected static string $resource = MeemOriginalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
