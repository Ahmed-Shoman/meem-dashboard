<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudiobookEpisodeResource\Pages;
use App\Models\AudiobookEpisode;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class AudiobookEpisodeResource extends Resource
{
    protected static ?string $model = AudiobookEpisode::class;

    protected static ?string $navigationLabel = 'الحلقات الصوتية';

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('audiobook_id')
                ->label('الكتاب الصوتي')
                ->relationship('audiobook', 'program_name')
                ->required(),
            Forms\Components\FileUpload::make('cover_image')
                ->label('صورة الغلاف')
                ->image()
                ->nullable(),
            Forms\Components\TextInput::make('audio_file')
                ->label('ملف الصوت')
                ->required(),
            Forms\Components\TextInput::make('audio_duration')
                ->label('مدة الحلقة الصوتية')
                ->required(),
            // Forms\Components\TextInput::make('category')
            //     ->label('التصنيف')
            //     ->required(),
            Forms\Components\Textarea::make('description')
                ->label('وصف الحلقة الصوتية')
                ->nullable(),
            Forms\Components\Textarea::make('short_description')
                ->label('الوصف الفرعي')
                ->nullable(),
            Forms\Components\Toggle::make('is_active')
                ->label('حالة الحلقة الصوتية')
                ->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('audiobook.program_name')
                ->label('اسم البرنامج'),
            Tables\Columns\TextColumn::make('category')
                ->label('التصنيف'),
            Tables\Columns\TextColumn::make('audio_duration')
                ->label('مدة الحلقة الصوتية'),
            Tables\Columns\ImageColumn::make('cover_image')
                ->label('صورة الغلاف'),
            Tables\Columns\BooleanColumn::make('is_active')
                ->label('حالة الحلقة الصوتية'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudiobookEpisodes::route('/'),
            'create' => Pages\CreateAudiobookEpisode::route('/create'),
            'edit' => Pages\EditAudiobookEpisode::route('/{record}/edit'),
        ];
    }
}