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
                        ->label('الإيميل'),
                    TextInput::make('plain_password')
                        ->required()
                        ->password()
                        ->label('كلمة المرور'),
                ]),

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

                Section::make('البرنامج المرتبط')
                    ->schema([
                        Select::make('program_id')
                            ->label('اختر البرنامج')
                            ->relationship('program', 'program_name')

                        ->options(function () {
                            $programs = \App\Models\Program::pluck('program_name', 'id')->toArray();
                            $onTheFly = \App\Models\OnTheFly::pluck('program_name', 'id')->toArray();
                            $articles = \App\Models\News::pluck('title', 'id')->toArray();
                            $audioBooks = \App\Models\Audiobook::pluck('program_name', 'id')->toArray(); 

                            // Convert to new unique keys
                            $onTheFly = collect($onTheFly)->mapWithKeys(fn($name, $id) => ['OTF-' . $id => $name])->toArray();
                            $articles = collect($articles)->mapWithKeys(fn($name, $id) => ['ART-' . $id => $name])->toArray();
                            $audioBooks = collect($audioBooks)->mapWithKeys(fn($name, $id) => ['AUD-' . $id => $name])->toArray();

                            return array_merge($programs, $onTheFly, $articles, $audioBooks);
                        })

                            ->nullable()
                            ->preload()
                            ->disabled(fn () => !auth()->user()->isAdmin())
                            ->placeholder('اختر برنامجًا من القائمة'),
                    ])
                    ->visible(fn () => auth()->user()->isAdmin()),

                Section::make('حالة المشرف')
                    ->schema([
                        Forms\Components\Toggle::make('is_admin')
                            ->label('مشرف؟')
                            ->default(false)
                            ->visible(fn () => auth()->user()->isAdmin()),
                    ])
                    ->visible(fn () => auth()->user()->isAdmin()),

                Section::make('وسائل التواصل الاجتماعي')
                    ->schema([
                        Repeater::make('social_accounts')
                            ->label('وسائل التواصل الاجتماعي / البودكاست')
                            ->schema([
                                Select::make('platform')
                                    ->label('المنصة')
                                    ->required()
                                    ->options([
                                        'social' => [
                                            'facebook' => 'فيسبوك',
                                            'twitter' => 'تويتر',
                                            'instagram' => 'إنستاجرام',
                                            'linkedin' => 'لينكدإن',
                                            'youtube' => 'يوتيوب',
                                            'tiktok' => 'تيك توك',
                                            'snapchat' => 'سناب شات',
                                            'whatsapp' => 'واتساب',
                                            'telegram' => 'تليجرام',
                                            'threads' => 'ثريدز',
                                        ],
                                        'podcast' => [
                                            'spotify' => 'سبوتيفاي',
                                            'apple_podcasts' => 'آبل بودكاست',
                                            'google_podcasts' => 'جوجل بودكاست',
                                            'soundcloud' => 'ساوند كلاود',
                                            'castbox' => 'كاست بوكس',
                                            'deezer' => 'ديزر',
                                            'stitcher' => 'ستيتشر',
                                            'audible' => 'أوديبل',
                                        ],
                                    ])
                                    ->searchable(),
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
            ]);
    }

public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->query(function () {
            $query = User::query();
            if (!auth()->user()->isAdmin()) {
                $query->where('program_id', auth()->user()->program_id);
            }
            return $query;
        })
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
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make()->visible(fn ($record) => auth()->user()->can('update', $record)),
            Tables\Actions\DeleteAction::make()->visible(fn ($record) => auth()->user()->can('delete', $record)),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()->visible(fn () => auth()->user()->isAdmin()),
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

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
