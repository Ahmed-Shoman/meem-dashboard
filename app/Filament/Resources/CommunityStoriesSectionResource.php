<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityStoriesSectionResource\Pages;
use App\Models\CommunityStoriesSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CommunityStoriesSectionResource extends Resource
{
    protected static ?string $model = CommunityStoriesSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Community Stories';
    protected static ?string $navigationGroup = 'Meem Articles Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Community Stories Section')
                    ->schema([
                        TextInput::make('main_title')
                            ->label('Main Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Repeater::make('links')
                            ->label('Links')
                            ->schema([
                                TextInput::make('label')
                                    ->label('Link Label')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('url')
                                    ->label('Link URL')
                                    ->required()
                                    ->url()
                                    ->maxLength(2048)
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(1)
                            ->reorderable()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description (with links)')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('main_title')
                    ->label('Main Title')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => Pages\ListCommunityStoriesSections::route('/'),
            'create' => Pages\CreateCommunityStoriesSection::route('/create'),
            'edit' => Pages\EditCommunityStoriesSection::route('/{record}/edit'),
        ];
    }
}