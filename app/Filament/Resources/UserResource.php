<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'المستخدمين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('المعلومات الأساسية')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('الاسم')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->label('الإيميل')
                            ->unique(),
                        TextInput::make('password')
                            ->password()
                            ->label('كلمة المرور')
                            ->required(fn (string $operation) => $operation === 'create')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->placeholder('اترك الحقل فارغًا لعدم التغيير'),
                    ])
                    ->columns(2),

                Section::make('المعلومات الإضافية')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->label('الصورة')
                            ->nullable()
                            ->maxSize(2048)
                            ->directory('user-images')
                            ->imageEditor(),
                        Textarea::make('bio')
                            ->label('السيرة الذاتية')
                            ->nullable()
                            ->rows(3),
                    ])
                    ->columns(1),

                Section::make('نوع الدور')
                    ->schema([
                        TextInput::make('role_type')
                            ->label('نوع الدور')
                            ->required()
                            ->default('user')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('role', [
                                    'type' => $state,
                                    'permissions' => $state === 'admin' ? ['create', 'edit', 'delete'] : ['view'],
                                ]);
                            }),
                        Forms\Components\Hidden::make('role')
                            ->default(['type' => 'user', 'permissions' => ['view']]),
                    ])
                    ->columns(1),

                Section::make('وسائل التواصل الاجتماعي')
                    ->schema([
                        Repeater::make('social_accounts')
                            ->label('وسائل التواصل الاجتماعي')
                            ->schema([
                                TextInput::make('platform')
                                    ->label('المنصة')
                                    ->required(),
                                TextInput::make('url')
                                    ->label('الرابط')
                                    ->url()
                                    ->required()
                                    ->placeholder('https://example.com'),
                            ])
                            ->addActionLabel('إضافة منصة')
                            ->defaultItems(1)
                            ->columns(2),
                    ])
                    ->columns(1),

                Section::make('البرنامج المرتبط')
                    ->schema([
                        Select::make('program_id')
                            ->label('اختر البرنامج')
                            ->relationship('program', 'program_name')
                            ->options(
                                \App\Models\Program::all()->pluck('program_name', 'id')->toArray()
                            )
                            ->searchable()
                            ->nullable()
                            ->placeholder('اختر برنامجًا من القائمة'),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('الإيميل')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('الصورة')
                    ->circular(),
                TextColumn::make('role.type')
                    ->label('نوع الدور')
                    ->default('غير محدد')
                    ->sortable(),
                TextColumn::make('program.program_name')
                    ->label('البرنامج المرتبط')
                    ->default('غير مرتبط')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
