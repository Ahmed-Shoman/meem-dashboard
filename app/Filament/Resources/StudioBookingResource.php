<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudioBookingResource\Pages;
use App\Models\StudioBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudioBookingResource extends Resource
{
    protected static ?string $model = StudioBooking::class;
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

        protected static ?string $navigationGroup = 'Home Page Sections';


    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
             Forms\Components\Grid::make(1)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),
                Forms\Components\Textarea::make('description1')
                    ->label('Description 1'),

                    Forms\Components\Textarea::make('description2')
                    ->label('Description 2'),

                Forms\Components\Repeater::make('studio_images')
                    ->label('Studio Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->required()
                        ->maxSize(20971520),
                    ])
                    ->collapsible(),

                Forms\Components\Repeater::make('equipment_list')
                    ->label('Equipment List')
                    ->schema([
                        Forms\Components\TextInput::make('equipment_name')
                            ->label('Equipment Name')
                            ->required(),
                    ])
                    ->collapsible(),

                Forms\Components\TextInput::make('cta_button_text')
                    ->label('CTA Button Text'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_button_text')
                    ->label('CTA Button'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudioBookings::route('/'),
            'create' => Pages\CreateStudioBooking::route('/create'),
            'edit' => Pages\EditStudioBooking::route('/{record}/edit'),
        ];
    }
}
