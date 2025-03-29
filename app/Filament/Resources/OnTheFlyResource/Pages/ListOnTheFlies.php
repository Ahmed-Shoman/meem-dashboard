<?php

namespace App\Filament\Resources\OnTheFlyResource\Pages;

use App\Filament\Resources\OnTheFlyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnTheFlies extends ListRecords
{
    protected static string $resource = OnTheFlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
