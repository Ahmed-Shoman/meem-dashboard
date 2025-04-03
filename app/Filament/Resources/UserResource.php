<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Program;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'المستخدمين';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull()
                    ->visible(fn () => auth()->check() && auth()->user()->isAdmin()),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bio')
                    ->label('السيرة الذاتية')
                    ->columnSpanFull()
                    ->required(),
Forms\Components\Toggle::make('is_admin')
    ->label('هل هو مدير؟')
    ->required()
    ->columnSpanFull()
    ->visible(fn () => auth()->check() && auth()->user()->isAdmin()),
                Forms\Components\TextInput::make('role')
                    ->label('الوظيفة - الدور')
                    ->maxLength(255)
                    ->required()
                    ->default(null)
                    ->columnSpanFull(),
Forms\Components\Repeater::make('social_media')
    ->label('وسائل التواصل الاجتماعي')
    ->schema([
       Forms\Components\Select::make('platform')
            ->label('المنصة')
            ->options([
                'x' => 'X (تويتر)',
                'instagram' => 'إنستجرام',
                'facebook' => 'فيسبوك',
                'youtube' => 'يوتيوب',
                'tiktok' => 'تيك توك',
                'snapchat' => 'سناب شات',
                'apple_podcast' => 'آبل بودكاست',
                'spotify' => 'سبوتيفاي',
                'anghami' => 'أنغامي',
            ])
            ->required(),
            
         Forms\Components\TextInput::make('url')
            ->label('رابط المنصة')
            ->url()
            ->required()
            ->prefix('https://')
            ->placeholder('example.com/yourpage'),
    ])
    ->columns(2)
    ->columnSpanFull()
    ->minItems(1)
    ->defaultItems(1)
    ->addActionLabel('إضافة منصة جديدة')
    ->collapsible(),
Forms\Components\Repeater::make('assignable')
    ->label('البرامج التابعة للعضو الجديد')
    ->schema([
        Forms\Components\Select::make('program_id')
            ->label('اسم البرنامج')
            ->options(Program::pluck('program_name', 'id')->toArray())
            ->searchable()
            ->required()
            ->columnSpanFull(),
    ])
    ->columns(2)
    ->columnSpanFull()
    ->minItems(1)
    ->defaultItems(1)
    ->reorderable()
    ->addActionLabel('إضافة برنامج جديد')
    ->collapsible()
    ->required()
    ->visible(fn () => auth()->user()->isAdmin()),
            ]);
    }


    public static function table(Table $table): Table
    {
        
        return $table
         ->query(function () {
            $query = User::query();

            // Limit users to only see themselves if they are not an admin
            if (!auth()->user()->isAdmin()) {
                $query->where('id', auth()->id());
            }

            return $query;
        })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة'),
                // Tables\Columns\IconColumn::make('is_admin')
                //     ->label('هل هو مدير؟')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('role')
                    ->label('الوظيفة - الدور')
                    ->searchable(),
            ])
            ->filters([ 
                // Add any filters here if needed
            ])
            ->actions([
    // View action for all users, but each user can only see their own records
    Tables\Actions\ViewAction::make()
        ->visible(fn ($record) => auth()->user()->isAdmin() || auth()->user()->id === $record->id),

    // Edit action for admins and users, but each user can only edit their own records
    Tables\Actions\EditAction::make()
        ->visible(fn ($record) => auth()->user()->isAdmin() || auth()->user()->id === $record->id),

    // Delete action for admins only
    Tables\Actions\DeleteAction::make()
        ->visible(fn () => auth()->user()->isAdmin()),
])
            ->bulkActions([
    // Bulk Delete action for admins only
    Tables\Actions\BulkActionGroup::make([
        Tables\Actions\DeleteBulkAction::make()
            ->visible(fn () => auth()->user()->isAdmin()), // Only admins can bulk delete
    ]),
]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

public static function getQuery(): Builder
{
    $query = parent::getQuery();

    // If the user is not an admin, filter to show only their own record
    if (!auth()->user()->isAdmin()) {
        $query->where('id', auth()->user()->id); // assuming the `user_id` field represents the owner of the record
    }

    return $query;
}

    public static function canCreate(): bool
{
    return auth()->user()->isAdmin();
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->isAdmin() || auth()->user()->id === $record->id; // Admin or the owner can edit
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->isAdmin();
}

public static function canViewAny(): bool
{
    return true;
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
