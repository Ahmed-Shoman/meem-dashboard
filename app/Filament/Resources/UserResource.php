<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use App\Models\User;
use Filament\Tables;
use App\Models\Program;
use App\Models\OnTheFly;
use Filament\Forms\Form;
use App\Models\Audiobook;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource\Pages;

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
                        TextInput::make('role')
                            ->required()
                            ->label('الدور - الوظيفه'),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->label('كلمة المرور')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    ]),

                Section::make('المعلومات الإضافية')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->label('الصورة')
                            ->imageEditor()
                            ->required()
                            ->directory('user-images')
                            ->imageEditor(),
                        Textarea::make('bio')
                            ->label('السيرة الذاتية')
                            ->required()
                            ->rows(3),
                    ])
                    ->columns(1),

Section::make('البرنامج المرتبط')
    ->schema([
        Repeater::make('assignable')
            ->label('البرامج المرتبطة')
            ->schema([
                Select::make('assignable_type')
                    ->label('نوع البرنامج المرتبط')
                    ->options([
                        'بودكاست' => 'بودكاست',
                        'عالطاير' => 'عالطاير',
                        'كتب صوتية' => 'كتب صوتية',
                        'جريدة' => 'جريدة',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('id', null); // Reset the selected program when type changes
                        $set('program_name', null); // Reset program name
                    }),

                Select::make('id')
                    ->label('البرنامج المختار')
                    ->options(function ($get) {
                        $assignableType = $get('assignable_type');
                        $programs = [];

                        if ($assignableType === 'بودكاست') {
                            $programs = Program::pluck('program_name', 'id')->toArray();
                        } elseif ($assignableType === 'عالطاير') {
                            $programs = OnTheFly::pluck('program_name', 'id')->toArray();
                        } elseif ($assignableType === 'جريدة') {
                            $programs = News::pluck('program_name', 'id')->toArray();
                        } elseif ($assignableType === 'كتب صوتية') {
                            $programs = Audiobook::pluck('program_name', 'id')->toArray();
                        }

                        return $programs ?: ['' => 'لا توجد برامج متاحة'];
                    })
                    ->required()
                    ->searchable()
                    ->placeholder('اختر برنامجًا من القائمة')
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $programId = $state;
                        $assignableType = $get('assignable_type');

                        if ($programId && $assignableType) {
                            $programName = match ($assignableType) {
                                'بودكاست' => Program::find($programId)->program_name ?? 'غير معروف',
                                'عالطاير' => OnTheFly::find($programId)->program_name ?? 'غير معروف',
                                'جريدة' => News::find($programId)->program_name ?? 'غير معروف',
                                'كتب صوتية' => Audiobook::find($programId)->program_name ?? 'غير معروف',
                                default => 'غير معروف',
                            };

                            $set('program_name', $programName);
                        }
                    }),

                Hidden::make('program_name')
                    ->dehydrated(true), // Ensure this field is included in the form data
            ])
            ->columns(2)
            ->defaultItems(1)
            ->minItems(1)
            ->maxItems(5)
            ->dehydrateStateUsing(function ($state) {
                // Transform the repeater state into the desired assignable array format
                return array_map(function ($item) {
                    return [
                        'assignable_type' => $item['assignable_type'],
                        'id' => $item['id'],
                        'program_name' => $item['program_name'],
                    ];
                }, $state);
            }),
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
                        Repeater::make('social_media')
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

            // Limit users to only see themselves if they are not an admin
            if (!auth()->user()->isAdmin()) {
                $query->where('id', auth()->id());
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

            TextColumn::make('assignable')
                ->label('البرنامج المرتبط')
                ->formatStateUsing(function ($state, $record) {
                    // Check if assignable exists and is an array
                    if (!$record->assignable || !is_array($record->assignable)) {
                        return '—';
                    }

                    // Map through the assignable array and fetch program names
                    return collect($record->assignable)->map(function ($item) {
                        // Extract values from the assignable item
                        $programId = $item['program_id'] ?? null;
                        $programType = $item['assignable_type'] ?? '';
                        $programName = $item['program_name'] ?? 'غير معروف'; // Get program_name directly from the assignable array

                        // Format output based on program type
                        return match ($programType) {
                            'بودكاست' => 'برنامج: ' . $programName,
                            'عالطاير' => 'On The Fly: ' . $programName,
                            'جريدة' => 'أخبار: ' . $programName,
                            'كتب صوتية' => 'كتب صوتية: ' . $programName,
                            default => 'غير معروف',
                        };
                    })->implode(', '); // Join multiple items with a comma
                }),
        ])
        ->actions([
            Tables\Actions\ViewAction::make()
                ->visible(fn ($record) => $record->id === auth()->id() || auth()->user()->isAdmin()),

            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => $record->id === auth()->id() || auth()->user()->isAdmin()),

            Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->isAdmin()),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->visible(fn () => auth()->user()->isAdmin()),
        ]);
}


public static function canCreate(): bool
{
    return auth()->user()->isAdmin();
}

public static function canViewAny(): bool
{
    return true;
}

public static function canView(Model $record): bool
{
    return auth()->user()->isAdmin() || $record->id === auth()->id();
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->isAdmin() || $record->id === auth()->id() ;
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->isAdmin();
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
