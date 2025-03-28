<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';

    public static function getNavigationLabel(): string
    {
        return 'قسم من نحن ';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان قسم من نحن')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('وصف قسم من نحن')
                            ->required(),
                        Forms\Components\FileUpload::make('background_media')
                            ->label('خلفية قسم من نحن - فيديو ')
                            ->directory('uploads/about_section')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->columnSpanFull()
                            ->live()
                            ->maxSize(20971520),
                        Forms\Components\TextInput::make('title2')
                            ->label('عنوان قسم من نحن داخل الصندوق')
                            ->required(),
                        Forms\Components\TextInput::make('sub_title2')
                            ->label('عنوان فرعي لقسم من نحن داخل الصندوق')
                            ->required(),
                        Forms\Components\Textarea::make('sub_description2')
                            ->label('وصف قسم من نحن داخل الصندوق')
                            ->required(),
                        Forms\Components\TextInput::make('cta_text')
                            ->label('زر المزيد')
                            ->default('استكشاف المزيد'),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة خلفية الصندوق - صورة')
                            ->image()
                            ->directory('uploads/logos')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->maxSize(20971520)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان قسم من نحن'),

                Tables\Columns\TextColumn::make('description')
                    ->label('وصف قسم من نحن')
                    ->limit(50),

                Tables\Columns\TextColumn::make('cta_text')
                    ->label('زر المزيد'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
