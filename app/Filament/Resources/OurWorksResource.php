<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OurWorksResource\Pages;
use App\Models\OurWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OurWorksResource extends Resource
{
    protected static ?string $model = OurWork::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Home Page Sections';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Main Section')
                ->schema([
                    Forms\Components\TextInput::make('main_title')
                        ->label('Main Title')
                        ->required(),

                    Forms\Components\TextInput::make('subtitle')
                        ->label('Subtitle'),

                    Forms\Components\Textarea::make('description_text')
                        ->label('Description'),

                    Forms\Components\Repeater::make('client_logos')
                        ->label('Clients Logos')
                        ->schema([
                            Forms\Components\FileUpload::make('logo')
                                ->label('Logo')
                                ->image()
                                ->required()
                                ->maxSize(20971520),
                        ])
                        ->collapsible()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('banner_text')
                        ->label('Banner Text'),

                    Forms\Components\TextInput::make('listeners_stat')
                        ->label('Listeners Stat'),

                    Forms\Components\TextInput::make('listeners_stat_description')
                        ->label('Listeners Sub Stat'),

                    Forms\Components\TextInput::make('episodes_stat')
                        ->label('Episodes Stat'),

                    Forms\Components\TextInput::make('episodes_stat_description')
                        ->label('Episodes Sub Stat'),

                    Forms\Components\TextInput::make('programs_stat')
                        ->label('Programs Stat'),

                    Forms\Components\TextInput::make('programs_stat_description')
                        ->label('Programs Sub Stat'),

                    Forms\Components\Repeater::make('program_list')
                        ->label('Programs List')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Program Image')
                                ->image()
                                ->maxSize(20971520),

                            Forms\Components\Textarea::make('description')
                                ->label('Program Description'),

                            Forms\Components\TextInput::make('episode_duration')
                                ->label('Episode Duration'),
                        ])
                        ->collapsible()
                        ->columnSpanFull(),
                ])
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')->label('Main Title')->searchable(),
                Tables\Columns\TextColumn::make('subtitle')->label('Subtitle')->searchable(),
                Tables\Columns\TextColumn::make('description_text')->label('Description')->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('listeners_stat')->label('Listeners Stat'),
                Tables\Columns\TextColumn::make('listeners_stat_description')->label('Listeners Sub Stat'),
                Tables\Columns\TextColumn::make('episodes_stat')->label('Episodes Stat'),
                Tables\Columns\TextColumn::make('episodes_stat_description')->label('Episodes Sub Stat'),
                Tables\Columns\TextColumn::make('programs_stat')->label('Programs Stat'),
                Tables\Columns\TextColumn::make('programs_stat_description')->label('Programs Sub Stat'),
                Tables\Columns\TextColumn::make('banner_text')->label('Banner Text'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime()->sortable(),
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
            'index' => Pages\ListOurWorks::route('/'),
            'create' => Pages\CreateOurWorks::route('/create'),
            'edit' => Pages\EditOurWorks::route('/{record}/edit'),
        ];
    }
}