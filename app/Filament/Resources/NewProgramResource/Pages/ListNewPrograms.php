<?php

namespace App\Filament\Resources\NewProgramResource\Pages;

use App\Filament\Resources\NewProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewPrograms extends ListRecords
{
    protected static string $resource = NewProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
