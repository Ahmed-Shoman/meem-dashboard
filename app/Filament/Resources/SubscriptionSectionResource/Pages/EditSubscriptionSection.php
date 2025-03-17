<?php

namespace App\Filament\Resources\SubscriptionSectionResource\Pages;

use App\Filament\Resources\SubscriptionSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionSection extends EditRecord
{
    protected static string $resource = SubscriptionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
