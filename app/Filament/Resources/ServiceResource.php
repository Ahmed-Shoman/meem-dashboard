<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;


class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 13; 

    

    public static function getNavigationLabel(): string
    {
        return 'اضافة الخدمات';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('service_name')
                    ->label('عنوان الخدمة')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('وصف قوي ومناسب للخدمة المقدمة')
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_name')
                    ->label('اسم الخدمة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}