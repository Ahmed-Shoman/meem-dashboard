<?php

namespace App\Filament\Resources\StudioBookingResource\Pages;

use App\Filament\Resources\StudioBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudioBooking extends EditRecord
{
    protected static string $resource = StudioBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
