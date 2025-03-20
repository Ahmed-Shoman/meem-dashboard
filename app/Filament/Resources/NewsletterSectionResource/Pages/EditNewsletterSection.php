<?php

namespace App\Filament\Resources\NewsletterSectionResource\Pages;

use App\Filament\Resources\NewsletterSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterSection extends EditRecord
{
    protected static string $resource = NewsletterSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
