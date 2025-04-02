<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Program;
use App\Models\OnTheFly;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AudioLibrary;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\AudioLibraryResource\Pages;

class AudioLibraryResource extends Resource
{
    protected static ?string $model = AudioLibrary::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'برامج ميم';

    public static function getNavigationLabel(): string
    {
        return 'اضافة حلقات البرامج';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('قم باضافة الحلقات الي البرنامج الذي تريده:')
                    ->schema([
                        Select::make('program_id')
                            ->label('اختار البرنامج الذي تتبع له الحلقة')
                            ->options(function () {
                                $user = auth()->user();
                                if (!$user) return [];
                                
                                $assignablePrograms = collect($user->assignable ?? []);
                                $options = [];
                                
                                $podcastProgramNames = $assignablePrograms->where('assignable_type')->pluck('program_name')->all();
                                $podcastPrograms = Program::whereIn('program_name', $podcastProgramNames)
                                    ->pluck('program_name', 'id')
                                    ->mapWithKeys(fn($name, $id) => [$id => "بودكاست: {$name}"])
                                    ->toArray();
                                    
                                $onTheFlyProgramNames = $assignablePrograms->where('assignable_type')->pluck('program_name')->all();
                                $onTheFlyPrograms = OnTheFly::whereIn('program_name', $onTheFlyProgramNames)
                                    ->pluck('program_name', 'id')
                                    ->mapWithKeys(fn($name, $id) => [$id => "عالطاير: {$name}"])
                                    ->toArray();
                                    
                                return array_merge($podcastPrograms, $onTheFlyPrograms) ?: ['' => 'لا توجد برامج متاحة'];
                            })
                            ->required()
                            ->preload()
                            ->live() // Add live() to make it reactive
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    // Check both models to determine the type
                                    $program = Program::find($state);
                                    $onTheFly = OnTheFly::find($state);
                                    
                                    if ($program) {
                                        $set('episode_type', 'بودكاست');
                                    } elseif ($onTheFly) {
                                        $set('episode_type', 'عالطاير');
                                    }
                                }
                            }),

                        Forms\Components\Hidden::make('episode_type')
                            ->required()
                            ->dehydrated(true),
                            
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => auth()->id())
                            ->dehydrated(true),

                        Textarea::make('description')
                            ->label('عنوان الحلقه الاساسي')
                            ->required() // Added required
                            ->columnSpanFull(),

                        TextInput::make('category')
                            ->label('موضوع الحلقة')
                            ->required(),

                        TextInput::make('episode_number')
                            ->label('رقم الحلقة')
                            ->numeric()
                            ->required(),

                        TextInput::make('guest_name')
                            ->label('اسم الضيف')
                            ->required(),

                        TextInput::make('youtube_link')
                            ->label('رابط الحلقة علي يوتيوب')
                            ->url()
                            ->required()
                            ->columnSpanFull(), // Added to make it full width

                        TextInput::make('apple_podcast_link')
                            ->label('رابط الحلقة علي أبل بودكاست')
                            ->url()
                            ->required()
                            ->columnSpanFull(), // Added to make it full width

                        FileUpload::make('image')
                            ->label('صورة الغلاف الخارجي للحلقة')
                            ->image()
                            ->required()
                            ->imageEditor()
                            ->directory('audio-library-images') // Added directory
                            ->maxSize(20971520),

                        FileUpload::make('sound')
                            ->label('ارفاق الملف الصوتي للحلقة')
                            ->acceptedFileTypes(['audio/*'])
                            ->required()
                            ->directory('audio-library-files') // Added directory
                            ->maxSize(20971520),

                        Textarea::make('sub_description')
                            ->label('وصف مفصل عن محتوي الحلقة')
                            ->columnSpanFull(),

                        TextInput::make('sound_time')
                            ->label('مدة الحلقه - مثل: 20:20')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('حالة ظهور الحلقة - (تظهر - لا تظهر)')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('episode_number')
                    ->label('رقم الحلقة')
                    ->sortable(),

                TextColumn::make('program_id')
                    ->label('برنامج الحلقة')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        if ($record->episode_type === 'بودكاست') {
                            return Program::find($record->program_id)?->program_name ?? 'غير معروف';
                        } elseif ($record->episode_type === 'عالطاير') {
                            return OnTheFly::find($record->program_id)?->program_name ?? 'غير معروف';
                        }
                        return 'غير محدد';
                    }),

                TextColumn::make('category')
                    ->label('موضوع الحلقة')
                    ->searchable(),

                TextColumn::make('guest_name')
                    ->label('اسم الضيف')
                    ->searchable(),

                TextColumn::make('youtube_link')
                    ->label('رابط الحلقة علي يوتيوب')
                    ->limit(30)
                    ->url(fn($record) => $record->youtube_link, true),

                TextColumn::make('apple_podcast_link')
                    ->label('رابط الحلقة علي أبل بودكاست')
                    ->limit(30)
                    ->url(fn($record) => $record->apple_podcast_link, true),

                TextColumn::make('sound_time')
                    ->label('زمن الحلقة'),

                TextColumn::make('description')
                    ->label('عنوان الحلقة')
                    ->limit(50),

                TextColumn::make('sub_description')
                    ->label('وصف الحلقة')
                    ->limit(50),

                IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ اضافة الحلقة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // You might want to add filters here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => static::canEdit($record)),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => static::canDelete($record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->isAdmin()),
            ]);
    }

    private static function userHasAccessToRecord(Model $record): bool
    {
        $user = auth()->user();
        return $user && ($record->user_id === $user->id || $user->isAdmin());
    }


    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
{
    return true; // Ensure this is returning true
}

public static function canEdit(Model $record): bool
{
    $user = auth()->user();
    return $user && ($user->isAdmin() || static::userHasAccessToRecord($record));
}

public static function canDelete(Model $record): bool
{
    $user = auth()->user();
    return $user && ($user->isAdmin() || static::userHasAccessToRecord($record));
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudioLibraries::route('/'),
            'create' => Pages\CreateAudioLibrary::route('/create'),
            'edit' => Pages\EditAudioLibrary::route('/{record}/edit'),
        ];
    }
}