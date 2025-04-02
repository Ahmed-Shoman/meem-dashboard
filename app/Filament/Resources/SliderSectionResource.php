<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderSectionResource\Pages;
use App\Models\SliderSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SliderSectionResource extends Resource
{
    protected static ?string $model = SliderSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 14; 

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
                            ->imageEditor()
                            ->maxSize(20971520),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة الغلاف الخارجي للقسم')
                    ->directory('uploads/slider')
                    ->image()
                    ->imageEditor()
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
            'index' => Pages\ListSliderSections::route('/'),
            'create' => Pages\CreateSliderSection::route('/create'),
            'edit' => Pages\EditSliderSection::route('/{record}/edit'),
        ];
    }
}
