<?php

namespace App\Filament\Resources\StorySectionResource\Pages;

use App\Filament\Resources\StorySectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorySection extends EditRecord
{
    protected static string $resource = StorySectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
