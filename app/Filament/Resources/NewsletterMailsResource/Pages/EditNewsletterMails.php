<?php

namespace App\Filament\Resources\NewsletterMailsResource\Pages;

use App\Filament\Resources\NewsletterMailsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterMails extends EditRecord
{
    protected static string $resource = NewsletterMailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
