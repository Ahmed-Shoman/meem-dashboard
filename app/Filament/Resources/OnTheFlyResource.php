<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OnTheFlyResource\Pages;
use App\Models\OnTheFly;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OnTheFlyResource extends Resource
{
    protected static ?string $model = OnTheFly::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'برامج ميم';

    public static function getNavigationLabel(): string
    {
        return 'عالطاير';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('إضافة البرامج الفورية')
                    ->schema([
                        Forms\Components\TextInput::make('program_name')
                            ->label('اسم البرنامج')
                            ->required(),

                        Forms\Components\TextInput::make('presenter')
                            ->label('اسم المقدم / المقدمة للبرنامج')
                            ->required(),

                        Forms\Components\FileUpload::make('presenter_image')
                            ->label('صورة مقدم البرنامج')
                            ->directory('uploads/presenters')
                            ->image()
                            ->imageEditor()
                            ->nullable()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('instagram')
                            ->label('حساب انستجرام')
                            ->placeholder('https://www.instagram.com/username')
                            ->url()
                            ->nullable(),

                        Forms\Components\TextInput::make('snapchat')
                            ->label('حساب سناب شات')
                            ->placeholder('https://www.snapchat.com/add/username')
                            ->nullable(),

                        Forms\Components\TextInput::make('x')
                            ->label('حساب تويتر')
                            ->placeholder('https://twitter.com/username')
                            ->url()
                            ->nullable(),

                        Forms\Components\Textarea::make('program_description')
                            ->label('وصف البرنامج')
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الغلاف')
                            ->directory('uploads/logos')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('seasons')
                            ->label('عدد المواسم')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('episodes')
                            ->label('عدد الحلقات')
                            ->numeric()
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('حالة البرنامج')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program_name')
                    ->label('اسم البرنامج')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('presenter')
                    ->label('مقدم البرنامج')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('presenter_image')
                    ->label('صورة مقدم البرنامج')
                    ->size(50),

                Tables\Columns\TextColumn::make('instagram')
                    ->label('انستجرام')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('snapchat')
                    ->label('سناب شات')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('x')
                    ->label('تويتر')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('عدد المواسم'),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('عدد الحلقات'),

                Tables\Columns\TextColumn::make('program_description')
                    ->label('وصف البرنامج')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('حالة النشاط')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListOnTheFlies::route('/'),
            'create' => Pages\CreateOnTheFly::route('/create'),
            'edit' => Pages\EditOnTheFly::route('/{record}/edit'),
        ];
    }
}
