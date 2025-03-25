<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioLibraryResource\Pages;
use App\Models\AudioLibrary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AudioLibraryResource extends Resource
{
    protected static ?string $model = AudioLibrary::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Meems Programs Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Cover Image')
                    ->image()
                    ->required()
                    ->maxSize(20971520),

                Forms\Components\FileUpload::make('sound')
<<<<<<< HEAD
    ->label('Audio File')
    ->acceptedFileTypes(['audio/*'])
    ->nullable()
    ->required(),

=======
                    ->label('Audio File')
                    ->acceptedFileTypes(['audio/*'])->nullable()
                    ->required()
                    ->maxSize(20971520),
>>>>>>> 0fef3e09c54f373f8892fafbcaf420ea23c90530
                Forms\Components\TextInput::make('sound_time')
                    ->label('Audio Duration')
                    ->required(),

                Forms\Components\TextInput::make('category')
                    ->label('Category')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('sub_description')
                    ->label('Sub Description')
                    ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Cover Image'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sound_time')
                    ->label('Audio Duration'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
