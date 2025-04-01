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
    protected static ?string $navigationGroup = 'أقسام صفحة الجريدة';

    public static function getNavigationLabel(): string
    {
        return 'اضافة المقالات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اضافة مقالة جديدة')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان المقالة')
                            ->required()
                            ->maxLength(255)
                            ->nullable(),

                        Forms\Components\Textarea::make('content')
                            ->label('محتوى المقالة')
                            ->required()
                            ->rows(5),

                        Forms\Components\DatePicker::make('date')
                            ->label('تاريخ النشر')
                            ->nullable()
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة المقالة')
                            ->directory('uploads/news')
                            ->image()
                            ->imageEditor()
                            ->preserveFilenames()
                            ->visibility('public')
                            ->nullable()
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('author_name')
                            ->label('اسم المؤلف')
                            ->required()
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('author_bio')
                            ->label('نبذة عن المؤلف')
                            ->required()
                            ->nullable()
                            ->rows(3),

                        Forms\Components\FileUpload::make('author_profile_picture')
                            ->label('صورة المؤلف')
                            ->directory('uploads/authors')
                            ->image()
                            ->required()
                            ->imageEditor()
                            ->preserveFilenames()
                            ->visibility('public')
                            ->nullable()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('author_instagram')
                            ->label('رابط Instagram')
                            ->nullable()
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('author_snapchat')
                            ->label('رابط Snapchat')
                            ->nullable()
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('author_x_twitter')
                            ->label('رابط X/Twitter')
                            ->nullable()
                            ->url()
                            ->maxLength(255),
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
                    ->label('صورة المقالة')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان المقالة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('اسم المؤلف')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('تاريخ النشر')
                    ->date()
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
