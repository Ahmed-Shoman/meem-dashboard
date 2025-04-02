<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultantResource\Pages;
use App\Models\Consultant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ConsultantResource extends Resource
{
    protected static ?string $model = Consultant::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 7; 

    public static function getNavigationLabel(): string
    {
        return 'اضافة مستشارين ميم';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الاستشاري')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('bio')
                    ->label('نبذه بسيطه عن الاستشاري')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('الصورة الشخصيه للاستشاري')
                    ->image()
                    ->imageEditor()
                    ->maxSize(20971520),

                Forms\Components\TextInput::make('linkedin')
                    ->label('رابط صفحة لينكدان الخاصة بالاستشاري')
                    ->url()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bio')
                    ->label('نبذه تعريفيه')
                    ->searchable(),

                Tables\Columns\TextColumn::make('linkedin')
                    ->label('رابط لينكدان')

            ])
            ->filters([])
                    ->actions([
            Tables\Actions\ViewAction::make(), // View action for all users
            Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin visible edit
            Tables\Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->isAdmin()), // Only admin visible delete
        ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListConsultants::route('/'),
            'create' => Pages\CreateConsultant::route('/create'),
            'edit' => Pages\EditConsultant::route('/{record}/edit'),
        ];
    }
}
