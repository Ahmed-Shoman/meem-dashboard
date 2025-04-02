<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudiobookResource\Pages;
use App\Models\Audiobook;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;

class AudiobookResource extends Resource
{
    protected static ?string $model = Audiobook::class;

    protected static ?string $navigationGroup = 'برامج ميم';

    public static function getNavigationLabel(): string
    {
        return 'الكتب الصوتية';
    }

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('program_name')
                ->label('اسم الكتاب')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('presenter')
                ->label('مقدم الكتاب')
                ->required()
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('presenter_image')
                ->label('صورة مقدم الكتاب')
                ->image()
                ->nullable()
                ->required()
                ->imageEditor()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('description')
                ->label('وصف الكتاب الصوتي')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('صورة الكتاب الصوتي')
                ->image()
                ->nullable()
                ->required()
                ->imageEditor()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('instagram')
                ->label('رابط انستجرام')
                ->url()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('snapchat')
                ->label('رابط سناب شات')
                ->url()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('x')
                ->label('رابط تويتر')
                ->url()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('seasons')
                ->label('عدد الاجزاء')
                ->numeric()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('episodes')
                ->label('عدد الحلقات الصوتيه')
                ->numeric()
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->label('حالة النشاط')
                ->default(true)
                ->columnSpanFull(),
        ]);
    }





public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('program_name')
                ->label('اسم الكتاب')
                ->searchable(),

            Tables\Columns\TextColumn::make('presenter')
                ->label('مقدم الكتاب')
                ->searchable(),

            Tables\Columns\ImageColumn::make('presenter_image')
                ->label('صورة مقدم الكتاب'),

            Tables\Columns\ImageColumn::make('image')
                ->label('صورة الغلاف للكتاب الصوتي'),

            Tables\Columns\TextColumn::make('seasons')
                ->label('عدد الاجزاء'),

            Tables\Columns\TextColumn::make('episodes')
                ->label('عدد الحلقات الصوتيه'),

            Tables\Columns\TextColumn::make('instagram')
                ->label('انستجرام')
                ->url(fn($record) => $record->instagram)
                ->openUrlInNewTab(),

            Tables\Columns\TextColumn::make('snapchat')
                ->label('سناب شات')
                ->url(fn($record) => $record->snapchat)
                ->openUrlInNewTab(),

            Tables\Columns\TextColumn::make('x')
                ->label('تويتر')
                ->url(fn($record) => $record->x)
                ->openUrlInNewTab(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('حالة النشاط')
                ->boolean(),
        ])
        ->actions([
            ViewAction::make(), // View action for all users
            EditAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin visible edit

            DeleteAction::make()
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
            'index' => Pages\ListAudiobooks::route('/'),
            'create' => Pages\CreateAudiobook::route('/create'),
            'edit' => Pages\EditAudiobook::route('/{record}/edit'),
        ];
    }
}
