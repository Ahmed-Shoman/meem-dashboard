<?php

namespace App\Filament\Resources\SliderSectionResource\Pages;

use App\Filament\Resources\SliderSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSliderSection extends EditRecord
{
    protected static string $resource = SliderSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
