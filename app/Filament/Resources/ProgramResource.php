<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Home Page Sections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('title')
                //     ->label('اسم البرنامج')
                //     ->required(),
                Forms\Components\TextInput::make('presenter')
                    ->label('المقدم')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('صورة الغلاف')
                     ->directory('uploads/logos')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('seasons')
                    ->label('عدد المواسم')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('episodes')
                    ->label('عدد الحلقات')
                    ->numeric()
                    ->required(),

                    Forms\Components\TextInput::make('links')
                    ->label('Links')
                    ->required()
                    ->url(),

                    //  Forms\Components\TextInput::make('cta_button_text')
                    // ->label('button')
                    // ->required(),


                     Forms\Components\TextInput::make('program_name')
                    ->label('Program Name')
                    ->required(),


                   Forms\Components\FileUpload::make('audio')
    ->label('Audio File')
    ->directory('uploads/audio') // ✅ Store inside an audio folder
    ->acceptedFileTypes([
        'audio/mpeg',      // MP3
        'audio/wav',       // WAV
        'audio/ogg',       // OGG
        'audio/aac',       // AAC
        'audio/flac',      // FLAC
        'audio/x-ms-wma',  // WMA
        'audio/x-wav',     // Alternative WAV MIME type
        'audio/webm'       // WEBM
    ])
    ->maxSize(10240) // ✅ Set max file size (10MB)
    ->nullable()
    ->required(),


     Forms\Components\TextInput::make('audio_time')
         ->label('Audio Duration')
         ->required(),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الغلاف'),
                Tables\Columns\TextColumn::make('title')
                    ->label('اسم البرنامج')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('presenter')
                    ->label('المقدم')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('seasons')
                    ->label('المواسم'),
                Tables\Columns\TextColumn::make('episodes')
                    ->label('الحلقات'),
                      Tables\Columns\TextColumn::make('links')
                    ->label('Links')
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
