<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderSectionResource\Pages;
use App\Models\SliderSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderSectionResource extends Resource
{
    protected static ?string $model = SliderSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Services Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),

                Forms\Components\TextInput::make('subtitle')
                    ->label('Subtitle'),

                Forms\Components\Textarea::make('description')
                    ->label('Description'),

                Forms\Components\FileUpload::make('image')
                    ->label('Main Image')
                    ->directory('uploads/slider')
                    ->image()
                    ->maxsize(null),

                Forms\Components\Repeater::make('slider_images')
                    ->label('Slider Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->directory('uploads/slider')
                            ->image(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Main Image'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliderSections::route('/'),
            'create' => Pages\CreateSliderSection::route('/create'),
            'edit' => Pages\EditSliderSection::route('/{record}/edit'),
        ];
    }
}
