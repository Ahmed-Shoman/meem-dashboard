<?php

namespace App\Filament\Resources\CommunityStoriesSectionResource\Pages;

use App\Filament\Resources\CommunityStoriesSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommunityStoriesSections extends ListRecords
{
    protected static string $resource = CommunityStoriesSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
