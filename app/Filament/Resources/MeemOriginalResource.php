<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MeemOriginalResource\Pages;
use App\Models\MeemOriginal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MeemOriginalResource extends Resource
{
    protected static ?string $model = MeemOriginal::class;

    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationGroup = 'Meem Articles Section';
    protected static ?string $navigationLabel = 'Meem Originals';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('main_title')
                ->label('Main Title')
                ->required(),

            Forms\Components\FileUpload::make('image')
                ->label('Image')
                ->directory('uploads/originals')
                ->image()
                ->required()
                ->maxSize(20971520),

            Forms\Components\DatePicker::make('date')
                ->label('Date')
                ->required(),

            Forms\Components\TextInput::make('subtitle')
                ->label('Subtitle'),

            Forms\Components\Textarea::make('description')
                ->label('Description'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('Image'),

            Tables\Columns\TextColumn::make('main_title')
                ->label('Title')
                ->searchable(),

            Tables\Columns\TextColumn::make('date')
                ->label('Date'),

            Tables\Columns\TextColumn::make('subtitle')
                ->label('Subtitle')
                ->limit(30),

            Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->limit(40),
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
            'index' => Pages\ListMeemOriginals::route('/'),
            'create' => Pages\CreateMeemOriginal::route('/create'),
            'edit' => Pages\EditMeemOriginal::route('/{record}/edit'),
        ];
    }
}