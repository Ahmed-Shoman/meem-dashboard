<?php

namespace App\Filament\Resources\MissionSectionResource\Pages;

use App\Filament\Resources\MissionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMissionSection extends EditRecord
{
    protected static string $resource = MissionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
