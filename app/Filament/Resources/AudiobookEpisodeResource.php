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
    protected static ?string $navigationGroup = 'برامج ميم';
    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    public static function getNavigationLabel(): string
    {
        return 'الحلقات الصوتيه';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('audiobook_id')
                ->label('أختر الكتاب التي تتبع له الحلقة الصوتية')
                ->relationship('audiobook', 'program_name')
                ->required()
                ->searchable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('episode_number')
                ->label('رقم الحلقة')
                ->numeric()
                ->required()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('description')
                ->label('عنوان الحلقة الصوتية')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('guest_name')
                ->label('اسم الضيف')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('short_description')
                ->label('وصف الحلقة الصوتية')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('audio_file')
                ->label('الملف الصوتي للحلقة')
                ->acceptedFileTypes(['audio/*'])
                ->directory('audiobook_episodes')
                ->required()
                ->columnSpanFull(),


            Forms\Components\FileUpload::make('cover_image')
                ->label('صورة الغلاف الخارجي للحلقة')
                ->image()
                ->imageEditor()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('youtube_link')
                ->label('رابط الحلقة علي يوتيوب')
                ->url()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('apple_podcast_link')
                ->label('رابط الحلقة علي ابل بودكاست')
                ->url()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('audio_duration')
                ->label('مدة الحلقة الصوتية')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('category')
                ->label('موضوع الحلقة')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->label('حالة الحلقة الصوتية')
                ->default(true)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('audiobook.program_name')
                ->label('اسم الكتاب'),
            Tables\Columns\TextColumn::make('episode_number')
                ->label('رقم الحلقة')
                ->sortable(),
            Tables\Columns\TextColumn::make('description')
                ->label('عنوان الحلقة')
                ->sortable(),

            Tables\Columns\ImageColumn::make('cover_image')
                ->label('صورة الغلاف'),
            Tables\Columns\TextColumn::make('guest_name')
                ->label('اسم الضيف'),
            Tables\Columns\TextColumn::make('category')
                ->label('التصنيف'),
            Tables\Columns\TextColumn::make('audio_duration')
                ->label('مدة الحلقة الصوتية'),
            Tables\Columns\TextColumn::make('youtube_link')
                ->label('رابط يوتيوب')
                ->url(fn($record) => $record->youtube_link)
                ->openUrlInNewTab(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('حالة النشاط')
                ->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
