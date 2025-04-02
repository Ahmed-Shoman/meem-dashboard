<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorySectionResource\Pages;
use App\Models\StorySection;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class StorySectionResource extends Resource
{
    protected static ?string $model = StorySection::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 8; 
    

    public static function getNavigationLabel(): string
    {
        return 'القسم التاني -  صفحة قصتنا';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان القسم الاول في صفحة من نحن')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('وصف القسم الاول في صفحة من نحن')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة القسم الاول في صفحة من نحن')
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull()
                    ->maxSize(20971520),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الاضافة')
                    ->dateTime(),
            ])
                    ->actions([
            Tables\Actions\ViewAction::make(), // View action for all users
            Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin visible edit
            Tables\Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin visible delete
        ]);
    }

    public static function canCreate(): bool
{
    return auth()->user()->isAdmin(); // Only admins can create
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->isAdmin(); // Only admins can edit
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->isAdmin(); // Only admins can delete
}

public static function canViewAny(): bool
{
    return true; // All users can view
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStorySections::route('/'),
            'create' => Pages\CreateStorySection::route('/create'),
            'edit' => Pages\EditStorySection::route('/{record}/edit'),
        ];
    }
}
