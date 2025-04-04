<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table; 
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $navigationLabel = 'البودكاست وعالطاير والكتب';
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $label = 'برنامج';
    protected static ?string $pluralLabel = 'برامج';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('program_name')
                    ->label('اسم البرنامج')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('presenter')
                    ->label('اسم المقدم')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('presenter_image')
                    ->label('صورة المقدم')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('صورة الغلاف الخارجي للبرنامج')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->rows(5) 
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('seasons')
                    ->label('عدد المواسم')
                    ->numeric()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('episodes')
                    ->label('عدد الحلقات')
                    ->numeric()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->label('نوع البرنامج')
                    ->options([
                        'كتاب صوتي' => 'كتاب صوتي',
                        'بودكاست' => 'بودكاست', 
                        'عالطاير' => 'عالطاير',
                    ])
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('instagram')
                    ->label('انستاجرام')
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('snapchat')
                    ->label('سناب شات')
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('x')
                    ->label('X')
                    ->url()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program_name')
                    ->label('اسم البرنامج')
                    ->searchable(),
                Tables\Columns\TextColumn::make('presenter')
                    ->label('المقدم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع البرنامج'),
            ])
            ->filters([
                //
            ])
            ->actions([
    // View action is available for all users
    Tables\Actions\ViewAction::make(),

    // Edit action is only available for admins
    Tables\Actions\EditAction::make('edit')
        ->label('تعديل')
        ->visible(fn () => auth()->user()->isAdmin()), // Only admins can edit

    // Delete action is only available for admins
    Tables\Actions\DeleteAction::make('delete')
        ->label('حذف')
        ->visible(fn () => auth()->user()->isAdmin()), // Only admins can delete
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
