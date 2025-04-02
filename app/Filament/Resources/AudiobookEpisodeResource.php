<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\AudiobookEpisode;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\AudiobookEpisodeResource\Pages;
use Filament\Tables\Table;

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
    Select::make('audiobook_id')
    ->label('أختر الكتاب التي تتبع له الحلقة الصوتية')
    ->relationship('audiobook', 'program_name')  // This assumes the relationship is set correctly
    ->required()
    ->columnSpanFull()
    ->options(function ($state) {
        // Get the current user
        $user = auth()->user();

        // Filter the assignable field to get the program_names for "كتب صوتية"
        $assignablePrograms = collect($user->assignable)
            ->where('assignable_type', 'كتب صوتية') 
            ->pluck('program_name'); 

        // Now, filter audiobooks based on the program_name from the assignable field
        return \App\Models\Audiobook::whereIn('program_name', $assignablePrograms)  // Adjust column to program_name
            ->pluck('program_name', 'id');
    }),

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

    public static function table(Table $table): Table
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
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make()
                ->visible(fn($record) => static::canEdit($record)),
            Tables\Actions\DeleteAction::make()
                ->visible(fn($record) => static::canDelete($record)),
        ]);
    }

    // Helper method to check if the current user has access to the record
    private static function userHasAccessToRecord(Model $record): bool
    {
        $user = auth()->user();
        if (!$user || !$record instanceof AudiobookEpisode) {
            return false;
        }

        // Get the audiobook ID from the episode
        $audiobookId = $record->audiobook_id;

        // Check if the user's assignable array contains this audiobook
        $assignable = $user->assignable ?? [];
        foreach ($assignable as $item) {
            if (isset($item['assignable_type']) && $item['assignable_type'] === 'كتب صوتية' &&
                isset($item['id']) && $item['id'] == $audiobookId) {
                return true;
            }
        }

        return false;
    }

    public static function canCreate(): bool
    {
        return true; // All users can create
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        return $user->isAdmin() || static::userHasAccessToRecord($record);
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        return $user->isAdmin() || static::userHasAccessToRecord($record);
    }

    public static function canViewAny(): bool
    {
        return true; // All users can view
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
