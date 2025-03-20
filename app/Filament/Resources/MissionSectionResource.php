<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MissionSectionResource\Pages;
use App\Filament\Resources\MissionSectionResource\Pages\CreateMissionSection;
use App\Filament\Resources\MissionSectionResource\Pages\EditMissionSection;
use App\Filament\Resources\MissionSectionResource\Pages\ListMissionSections;
use App\Models\MissionSection;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MissionSectionResource extends Resource
{
    protected static ?string $model = MissionSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';
       protected static ?string $navigationGroup = 'About us Page Sections';
    protected static ?string $label = 'Mission Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('main_title')
                    ->label('Main Title')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('title2')
                    ->label('Secondary Title')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description2')
                    ->label('Secondary Description')
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('points')
                    ->label('Mission Points')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Point Title')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Point Description'),

                        Forms\Components\TextInput::make('number')
                            ->label('Point Number')
                            ->numeric()
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')
                    ->label('Main Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title2')
                    ->label('Secondary Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),

                Tables\Columns\TextColumn::make('description2')
                    ->label('Secondary Description')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMissionSections::route('/'),
            'create' => Pages\CreateMissionSection::route('/create'),
            'edit' => Pages\EditMissionSection::route('/{record}/edit'),
        ];
    }
}