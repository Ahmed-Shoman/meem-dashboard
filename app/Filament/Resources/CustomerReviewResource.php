<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerReviewResource\Pages;
use App\Models\CustomerReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerReviewResource extends Resource
{
    protected static ?string $model = CustomerReview::class;
    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationGroup = 'Services Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('opinion')
                    ->label('Customer Opinion')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('name')
                    ->label('Customer Name')
                    ->required(),

                Forms\Components\TextInput::make('role')
                    ->label('Customer Role')
                    ->nullable(),

                Forms\Components\FileUpload::make('avatar')
                    ->label('Customer Avatar')
                    ->directory('uploads/avatars')
                    ->image()
                    ->nullable()
                ->maxSize(20971520),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role'),

                Tables\Columns\TextColumn::make('opinion')
                    ->label('Opinion')
                    ->limit(100),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerReviews::route('/'),
            'create' => Pages\CreateCustomerReview::route('/create'),
            'edit' => Pages\EditCustomerReview::route('/{record}/edit'),
        ];
    }
}