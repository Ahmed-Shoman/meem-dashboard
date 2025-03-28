<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderSectionResource\Pages;
use App\Models\SliderSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderSectionResource extends Resource
{
    protected static ?string $model = SliderSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'أقسام صفحة خدماتنا';

    public static function getNavigationLabel(): string
    {
        return 'صور قسم الخدمات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('العنوان الاساسي لقسم الخدمات')
                    ->required(),

                Forms\Components\TextInput::make('subtitle')
                    ->label('عنوان بسيط لقسم الخدمات'),

                Forms\Components\Textarea::make('description')
                    ->label('وصف مناسب لقسم الخدمات'),


                Forms\Components\Repeater::make('slider_images')
                    ->label('صور السلايدر المتحرك')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('ارفاق صورة')
                            ->directory('uploads/slider')
                            ->image()
                            ->maxSize(20971520),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة الغلاف الخارجي للقسم')
                    ->directory('uploads/slider')
                    ->image()
                    ->maxSize(20971520),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الاضافة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliderSections::route('/'),
            'create' => Pages\CreateSliderSection::route('/create'),
            'edit' => Pages\EditSliderSection::route('/{record}/edit'),
        ];
    }
}
