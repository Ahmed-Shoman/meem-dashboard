<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
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
                // قسم المعلومات الأساسية
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
                            ->required(fn (string $operation) => $operation === 'create')
                            ->label('كلمة المرور')
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->dehydrated(fn ($state) => filled($state)),
                    ])
                    ->columns(2),

                // قسم المعلومات الإضافية
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
                        Toggle::make('is_admin')
                            ->label('مدير؟')
                            ->default(false),
                    ])
                    ->columns(2),

                // قسم نوع الدور
                Section::make('نوع الدور')
                    ->schema([
                        Select::make('role_type') // حقل مؤقت لاختيار نوع الدور
                            ->label('نوع الدور')
                            ->options([
                                'admin' => 'مدير',
                                'user' => 'مستخدم',
                                'editor' => 'محرر',
                            ])
                            ->required()
                            ->default('user')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // تحديث حقل role (JSON) بناءً على القيمة المختارة
                                $set('role', [
                                    'type' => $state,
                                    'permissions' => $state === 'admin' ? ['create', 'edit', 'delete'] : ['view'],
                                ]);
                            }),
                        // حقل مخفي لتخزين role كـ JSON
                        Forms\Components\Hidden::make('role')
                            ->default(['type' => 'user', 'permissions' => ['view']]),
                    ])
                    ->columns(2),

                // قسم وسائل التواصل الاجتماعي
                Section::make('وسائل التواصل الاجتماعي')
                    ->schema([
                        Select::make('social_media_platform')
                            ->label('منصة التواصل الاجتماعي')
                            ->options([
                                'facebook' => 'فيسبوك',
                                'twitter' => 'تويتر',
                                'instagram' => 'إنستاجرام',
                                'linkedin' => 'لينكدإن',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // إعادة تعيين الرابط عندما يتم تغيير المنصة
                                $set('social_media_url', '');
                            }),

                        // حقل رابط المنصة
                        TextInput::make('social_media_url')
                            ->label('رابط المنصة')
                            ->required()
                            ->url()
                            ->placeholder('https://example.com'),
                    ])
                    ->columns(2),
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
                TextColumn::make('bio')
                    ->label('السيرة الذاتية')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->bio),
                // IconColumn::make('is_admin')
                //     ->label('مدير؟')
                //     ->boolean(),
                TextColumn::make('role.type')
                    ->label('نوع الدور')
                    ->default('غير محدد')
                    ->sortable(),
                TextColumn::make('social_media_platform')
                    ->label('منصة التواصل الاجتماعي')
                    ->sortable(),
                TextColumn::make('social_media_url')
                    ->label('رابط المنصة')
                    ->url(fn ($state) => $state)  // عرض الرابط في شكل URL قابل للنقر
                    ->openUrlInNewTab(),
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

    // public static function getNavigationGroup(): ?string
    // {
    //     return 'إدارة المستخدمين';
    // }

    // public static function getNavigationLabel(): ?string
    // {
    //     return 'المستخدمين';
    // }

    // public static function canViewAny(): bool
    // {
    //     return auth()->user()->isAdmin();
    // }
}
