<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnershipResource\Pages;
use App\Models\Partnership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnershipResource extends Resource
{
    protected static ?string $model = Partnership::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
     protected static ?string $navigationGroup = 'About us Page Sections';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('cta_button_text')
                    ->label('CTA Button Text')
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('images')
                    ->label('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->required()
                    ->maxSize(20971520)

                    ])
                    ->columnSpanFull()
                   -> collapsible(),
            ]);

    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),

                Tables\Columns\TextColumn::make('cta_button_text')
                    ->label('CTA Button Text'),

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
            'index' => Pages\ListPartnerships::route('/'),
            'create' => Pages\CreatePartnership::route('/create'),
            'edit' => Pages\EditPartnership::route('/{record}/edit'),
        ];
    }
}