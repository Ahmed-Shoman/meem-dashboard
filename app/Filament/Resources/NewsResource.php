<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'أقسام صفحة الأخبار';

    public static function getNavigationLabel(): string
    {
        return 'اضافة الاخبار';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اضافة أخبار وقصص نجاح قناة ميم')
                    ->schema([
                        Forms\Components\TextInput::make('main_title')
                            ->label('عنوان الخبر')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('وصف بسيط عن الخبر')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('وصف مفصل وشامل كل شي عن الخبر أو قصه النجاح')
                            ->rows(5),

                        Forms\Components\DatePicker::make('date')
                            ->label('تاريخ اضافة الخبر')
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الغلاف الخارجي للخبر')
                            ->directory('uploads/news')
                            ->image()
                            ->preserveFilenames()
                            ->visibility('public')
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\Select::make('category')
                            ->label('نوع الخبر يمكنك الاختيار بين: ')
                            ->options([
                                'news' => 'خبر',
                                'originals' => 'قصة نجاح',
                            ])
                            ->nullable(),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('main_title')
                    ->label('Main Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
