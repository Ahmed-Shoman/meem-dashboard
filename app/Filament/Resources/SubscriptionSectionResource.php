<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionSectionResource\Pages;
use App\Models\SubscriptionSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionSectionResource extends Resource
{
    protected static ?string $model = SubscriptionSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Home Page Sections';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main Title
                Forms\Components\TextInput::make('main_title')
                    ->label('Main Title')
                    ->required()
                    ->columnSpanFull(),

                // Plans (Repeater)
                Forms\Components\Repeater::make('plan_details')
                    ->label('Subscription Plans')
                    ->schema([
                        Forms\Components\TextInput::make('plan_name')
                            ->label('Plan Name')
                            ->required(),

                        Forms\Components\Textarea::make('plan_description')
                            ->label('Plan Description'),

                        Forms\Components\TextInput::make('plan_price')
                            ->label('Plan Price')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                // FAQs Section (Repeater)
                Forms\Components\Repeater::make('faqs')
                    ->label('FAQs')
                    ->schema([
                        Forms\Components\TextInput::make('question')
                            ->label('Question')
                            ->required(),

                        Forms\Components\Textarea::make('answer')
                            ->label('Answer')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                // Listen Now Section
                Forms\Components\Section::make('Listen Now Section')
                    ->schema([
                        Forms\Components\TextInput::make('listen_now_title')
                            ->label('Listen Now Title')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('listen_now_text')
                            ->label('Listen Now Description')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('listen_now_image')
                            ->label('Listen Now Image')
                            ->image(),

                        Forms\Components\Repeater::make('platform_links')
                            ->label('Platform Links')
                            ->schema([
                                Forms\Components\TextInput::make('platform_name')
                                    ->label('Platform Name')
                                    ->required(),

                                Forms\Components\TextInput::make('platform_url')
                                    ->label('Platform URL')
                                    ->url()
                                    ->required(),
                            ])
                            ->collapsible(),
                    ])
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

                Tables\Columns\TextColumn::make('plan_name')
                    ->label('Plan Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan_price')
                    ->label(' Plan Price')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan_description')
                    ->label(' plan description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plan_details')
                    ->label(' plan details')
                    ->searchable(),


                Tables\Columns\TextColumn::make('listen_now_title')
                    ->label('Listen Now Title')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('listen_now_image')
                    ->label('Listen Now Image'),

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
            'index' => Pages\ListSubscriptionSections::route('/'),
            'create' => Pages\CreateSubscriptionSection::route('/create'),
            'edit' => Pages\EditSubscriptionSection::route('/{record}/edit'),
        ];
    }
}