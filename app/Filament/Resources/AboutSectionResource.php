<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 5; 

    public static function getNavigationLabel(): string
    {
        return 'قسم من نحن في صفحة قصتنا';
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
                            ->imageEditor()
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
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
