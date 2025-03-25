<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacebookHighlightSectionResource\Pages;
use App\Models\FacebookHighlightSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FacebookHighlightSectionResource extends Resource
{
    protected static ?string $model = FacebookHighlightSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationGroup = 'Meem Articles Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('uploads/facebook_section')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Main Description')
                    ->required(),

                Forms\Components\Textarea::make('sub_description')
                    ->label('Sub Description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('sub_description')
                    ->label('Sub Description')
                    ->limit(50)
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacebookHighlightSections::route('/'),
            'create' => Pages\CreateFacebookHighlightSection::route('/create'),
            'edit' => Pages\EditFacebookHighlightSection::route('/{record}/edit'),
        ];
    }
}
