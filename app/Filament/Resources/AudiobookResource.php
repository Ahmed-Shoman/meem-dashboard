<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudiobookResource\Pages;
use App\Models\Audiobook;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Table;
use Filament\Tables;

class AudiobookResource extends Resource
{
    protected static ?string $model = Audiobook::class;

    protected static ?string $navigationLabel = 'الكتب الصوتية';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('presenter')
                ->label('مقدم البرنامج')
                ->required(),
            Forms\Components\TextInput::make('program_name')
                ->label('اسم البرنامج')
                ->required(),
            Forms\Components\FileUpload::make('image')
                ->label('صورة الكتاب الصوتي')
                ->image()
                ->nullable(),
            Forms\Components\TextInput::make('audio')
                ->label('ملف الصوت')
                ->required(),
            Forms\Components\TextInput::make('audio_duration')
                ->label('مدة الكتاب الصوتي')
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label('حالة الكتاب الصوتي')
                ->default(true),
            Forms\Components\Textarea::make('description')
                ->label('وصف الكتاب الصوتي')
                ->nullable(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('program_name')
                ->label('اسم البرنامج'),
            Tables\Columns\TextColumn::make('presenter')
                ->label('مقدم البرنامج'),
            Tables\Columns\ImageColumn::make('image')
                ->label('صورة الكتاب الصوتي'),
            Tables\Columns\TextColumn::make('audio_duration')
                ->label('مدة الكتاب الصوتي'),
            Tables\Columns\BooleanColumn::make('is_active')
                ->label('حالة الكتاب الصوتي'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudiobooks::route('/'),
            'create' => Pages\CreateAudiobook::route('/create'),
            'edit' => Pages\EditAudiobook::route('/{record}/edit'),
        ];
    }
}