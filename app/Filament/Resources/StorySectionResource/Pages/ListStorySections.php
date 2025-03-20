<?php

namespace App\Filament\Resources\StorySectionResource\Pages;

use App\Filament\Resources\StorySectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorySections extends ListRecords
{
    protected static string $resource = StorySectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
