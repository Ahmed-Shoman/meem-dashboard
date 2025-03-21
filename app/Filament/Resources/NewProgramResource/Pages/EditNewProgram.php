<?php

namespace App\Filament\Resources\NewProgramResource\Pages;

use App\Filament\Resources\NewProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewProgram extends EditRecord
{
    protected static string $resource = NewProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
