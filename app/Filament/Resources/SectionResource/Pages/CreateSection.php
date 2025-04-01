<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Section Created')
            ->body('The section has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
