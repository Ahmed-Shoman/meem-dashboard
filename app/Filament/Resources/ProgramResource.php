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
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Home Page Sections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('program_name')
                    ->label('Program Name')
                    ->required(),

                Forms\Components\TextInput::make('presenter')
                    ->label('المقدم')
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة الغلاف')
                    ->directory('uploads/logos')
                    ->image()
                    ->required()
                    ->maxSize(20971520),

                Forms\Components\TextInput::make('seasons')
                    ->label('عدد المواسم')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('episodes')
                    ->label('عدد الحلقات')
                    ->numeric()
                    ->required(),

                // Forms\Components\TextInput::make('links')
                //     ->label('رابط البرنامج')
                //     ->required()
                //     ->url(),

                // Forms\Components\FileUpload::make('audio')
                //     ->label('ملف صوتي / فيديو')
                //     ->directory('uploads/audio')
                //     ->acceptedFileTypes([
                //         // Audio formats
                //         'audio/mpeg',
                //         'audio/wav',
                //         'audio/ogg',
                //         'audio/aac',
                //         'audio/flac',
                //         'audio/x-ms-wma',
                //         'audio/x-wav',
                //         'audio/webm',
                //         // Video formats
                //         'video/mp4',
                //         'video/x-msvideo',
                //         'video/x-matroska',
                //         'video/webm',
                //         'video/ogg',
                //         'video/quicktime',
                //         'video/x-ms-wmv'
                //     ])
                //     ->nullable()
                //     ->required()
                //     ->maxSize(20971520),

                // Forms\Components\TextInput::make('audio_time')
                //     ->label('مدة الصوت / الفيديو')
                //     ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الغلاف'),

                Tables\Columns\TextColumn::make('program_name')
                    ->label('اسم البرنامج')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('presenter')
                    ->label('المقدم')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('عدد المواسم'),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('الحلقات'),

                Tables\Columns\TextColumn::make('links')
                    ->label('Links'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean(),
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
