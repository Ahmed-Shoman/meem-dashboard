<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultantResource\Pages;
use App\Models\Consultant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultantResource extends Resource
{
    protected static ?string $model = Consultant::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
       protected static ?string $navigationGroup = 'About us Page Sections';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('bio')
                    ->label('Bio')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Profile Image')
                    ->image(),

                Forms\Components\TextInput::make('linkedin')
                    ->label('LinkedIn Profile')
                    ->url()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Profile Image'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bio')
                    ->label('Bio')
                    ->searchable(),

                Tables\Columns\TextColumn::make('linkedin')
                    ->label('LinkedIn')

            ])
            ->filters([])
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
            'index' => Pages\ListConsultants::route('/'),
            'create' => Pages\CreateConsultant::route('/create'),
            'edit' => Pages\EditConsultant::route('/{record}/edit'),
        ];
    }
}