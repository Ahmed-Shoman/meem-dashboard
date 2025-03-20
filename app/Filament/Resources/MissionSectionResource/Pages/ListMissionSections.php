<?php

namespace App\Filament\Resources\MissionSectionResource\Pages;

use App\Filament\Resources\MissionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMissionSections extends ListRecords
{
    protected static string $resource = MissionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
