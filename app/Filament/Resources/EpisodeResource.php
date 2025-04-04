<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Models\Episode;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table; 
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;


class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    // protected static ?string $navigationGroup = 'البرامج';

    protected static ?string $navigationLabel = 'اضافة الحلقات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('short_description')
                    ->label('عنوان الحلقة')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('description')
                    ->label('وصف الحلقة')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('episode_type')
                    ->label('نوع الحلقة')
                    ->required()
                    ->columnSpanFull(),

// Program selection (visible)
// Program selection (visible)


Select::make('program_id')
    ->label('البرنامج الذي تتبع له الحلقه')
    ->options(function () {
        $query = Program::query();

        if (!auth()->user()->isAdmin()) {
            $query->whereIn('id', collect(auth()->user()->assignable)->pluck('program_id'));
        }

        return $query
            ->select('id', 'program_name', 'type')
            ->get()
            ->mapWithKeys(fn ($program) => [
                $program->id => "{$program->program_name} ({$program->type})"
            ]);
    })
    ->required()
    ->columnSpanFull()
    ->live()
    ->afterStateUpdated(function ($state, callable $set) {
        if ($state) {
            $program = Program::find($state);
            if ($program) {
                $set('category', $program->program_name);
            }
        }
    }),



// Category field (visible, auto-updated)
Forms\Components\TextInput::make('category')
    ->label('اسم البرنامج')
    ->readOnly()
    ->columnSpanFull(),

// User ID (hidden)
Forms\Components\Hidden::make('user_id')
    ->default(Auth::id()), // Automatically set to current user
                Forms\Components\TextInput::make('episode_number')
                    ->label('رقم الحلقة')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('guest_name')
                    ->label('اسم الضيف')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('youtube_link')
                    ->label('رابط يوتيوب')
                    ->required()
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('apple_podcast_link')
                    ->label('رابط آبل بودكاست')
                    ->required()
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('صورة الغلاف')
                    ->required()
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('audio_file')
                    ->label('ملف الصوت')
                    ->required()
                    ->acceptedFileTypes(['audio/*'])  // Accepts all audio types
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('audio_duration')
                    ->label('مدة الصوت')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('ادراج الحلقة')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
         ->query(function () {
            $query = Episode::query();

            // Limit users to only see themselves if they are not an admin
            if (!auth()->user()->isAdmin()) {
                $query->where('user_id', auth()->id());
            }

            return $query;
        })
            ->columns([
                Tables\Columns\TextColumn::make('episode_type')
                    ->label('نوع الحلقة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('episode_number')
                    ->label('رقم الحلقة'),
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('اسم الضيف'),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('الحلقة مدرجة')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }
}
