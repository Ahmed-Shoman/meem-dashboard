<?php

namespace App\Filament\Resources\AudiobookResource\Pages;

use App\Filament\Resources\AudiobookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAudiobook extends CreateRecord
{
    protected static string $resource = AudiobookResource::class;
}
