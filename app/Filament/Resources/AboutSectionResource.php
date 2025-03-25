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
    protected static ?string $navigationGroup = 'Home Page Sections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('About Section Settings')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان القسم')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('background_media')
                            ->label('خلفية القسم (صورة / فيديو)')
                            ->directory('uploads/about_section')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->live()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title2')
                            ->label('عنوان القسم الفرعي')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sub_title2')
                            ->label('العنوان الفرعي 2')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('sub_description2')
                            ->label('الوصف الفرعي')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('cta_text')
                            ->label('زر الدعوة')
                            ->default('استكشاف المزيد')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->label('خلفية الصندوق')
                            ->image()
                            ->directory('uploads/logos')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان القسم'),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),

                Tables\Columns\ImageColumn::make('background_media')
                    ->label('الخلفية')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('cta_text')
                    ->label('زر الدعوة'),

                Tables\Columns\ImageColumn::make('image')
                    ->label('خلفية الصندوق')
                    ->disk('public'),
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
