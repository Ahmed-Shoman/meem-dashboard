<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OnTheFlyResource\Pages;
use App\Models\OnTheFly;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;

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
                            ->required()
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
            Tables\Actions\ViewAction::make(), // View is available for all users

            Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin can edit

            Tables\Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin can delete
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin can bulk delete
        ]);
}

public static function query(EloquentBuilder $query): EloquentBuilder
{
    $user = auth()->user();

    if (!$user->isAdmin()) {
        return $query->whereJsonContains('assignable', [
            'program_id' => $user->assignable->pluck('program_id')->toArray(),
        ]);
    }

    return $query;
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
            'index' => Pages\ListOnTheFlies::route('/'),
            'create' => Pages\CreateOnTheFly::route('/create'),
            'edit' => Pages\EditOnTheFly::route('/{record}/edit'),
        ];
    }
}