<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // Changed to match OurWorksResource
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Section') // Added section like OurWorksResource
                    ->schema([
                        Forms\Components\TextInput::make('program_name')
                            ->label('Program Name')
                            ->required(),

                        Forms\Components\TextInput::make('presenter')
                            ->label('Presenter')
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Cover Image')
                            ->directory('uploads/logos')
                            ->image()
                            ->required()
                            ->maxSize(20971520), // 20MB limit, consistent with OurWorksResource

                        Forms\Components\TextInput::make('seasons')
                            ->label('Number of Seasons')
                            ->numeric()
                            ->default(1) // Added default like OurWorksResource
                            ->required(),

                        Forms\Components\TextInput::make('episodes')
                            ->label('Number of Episodes')
                            ->numeric()
                            ->default(1) // Added default
                            ->required(),

                        Forms\Components\FileUpload::make('audio')
                            ->label('Audio/Video File')
                            ->directory('uploads/audio')
                            ->acceptedFileTypes([
                                // Audio formats
                                'audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/aac',
                                'audio/flac', 'audio/x-ms-wma', 'audio/x-wav', 'audio/webm',
                                // Video formats
                                'video/mp4', 'video/x-msvideo', 'video/x-matroska',
                                'video/webm', 'video/ogg', 'video/quicktime', 'video/x-ms-wmv'
                            ])
                            ->nullable() // Kept nullable, removed conflicting required()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('audio_time')
                            ->label('Audio/Video Duration')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Forms\Components\Textarea::make('program_description')
                            ->label('Program Description')
                            ->required(), // Changed to Textarea for better UX with descriptions

                        // Optional Repeater, inspired by client_logos in OurWorksResource
                        Forms\Components\Repeater::make('additional_media')
                            ->label('Additional Media')
                            ->schema([
                                Forms\Components\FileUpload::make('media_file')
                                    ->label('Media File')
                                    ->directory('uploads/media')
                                    ->acceptedFileTypes([
                                        'audio/mpeg', 'audio/wav', 'video/mp4', 'video/webm', 'image/jpeg', 'image/png'
                                    ])
                                    ->maxSize(20971520),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Cover Image')
                    ->circular(), // Added for visual polish, optional

                Tables\Columns\TextColumn::make('program_name')
                    ->label('Program Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('presenter')
                    ->label('Presenter')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('Seasons'),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('Episodes'),

                Tables\Columns\TextColumn::make('audio_time')
                    ->label('Duration'),

                Tables\Columns\TextColumn::make('program_description')
                    ->label('Description')
                    ->limit(50) // Added limit like OurWorksResource
                    ->searchable(),

                Tables\Columns\TextColumn::make('audio')
                    ->label('Audio/Video File')
                    ->limit(50), // Added limit for consistency

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(), // Added like OurWorksResource
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Added like OurWorksResource
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