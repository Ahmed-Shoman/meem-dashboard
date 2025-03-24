<?php

namespace App\Filament\Resources\FacebookHighlightSectionResource\Pages;

use App\Filament\Resources\FacebookHighlightSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFacebookHighlightSection extends EditRecord
{
    protected static string $resource = FacebookHighlightSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
