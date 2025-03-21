<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\NewProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewProgramResource extends Resource
{
    protected static ?string $model = NewProgram::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Meems Programs Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Program Title')
                    ->required()
                    ->columnSpanFull(),

                // ✅ Repeater for Category (Stored as JSON)
                Forms\Components\Repeater::make('category')
                    ->label('Categories')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Category Name')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Program Image')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('seasons')
                    ->label('Number of Seasons')
                    ->numeric()
                    ->default(1),

                Forms\Components\TextInput::make('episodes')
                    ->label('Number of Episodes')
                    ->numeric()
                    ->default(1),

                Forms\Components\TextInput::make('producer')
                    ->label('Producer Name')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Program Description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Program Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categories')
                    ->limit(50),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Program Image'),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('Seasons')
                    ->sortable(),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('Episodes')
                    ->sortable(),

                Tables\Columns\TextColumn::make('producer')
                    ->label('Producer')
                    ->searchable(),

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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
