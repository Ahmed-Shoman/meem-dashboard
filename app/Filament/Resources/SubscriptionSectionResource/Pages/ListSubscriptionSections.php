<?php

namespace App\Filament\Resources\SubscriptionSectionResource\Pages;

use App\Filament\Resources\SubscriptionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionSections extends ListRecords
{
    protected static string $resource = SubscriptionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
