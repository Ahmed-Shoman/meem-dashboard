<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerReviewResource\Pages;
use App\Models\CustomerReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerReviewResource extends Resource
{
    protected static ?string $model = CustomerReview::class;
    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationGroup = 'أقسام صفحة خدماتنا';

    public static function getNavigationLabel(): string
    {
        return 'اضافة أراء العملاء';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم العميل')
                    ->required(),

                Forms\Components\Textarea::make('opinion')
                    ->label('رأي العميل')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('role')
                    ->label('وظيفة العميل')
                    ->nullable(),

                Forms\Components\FileUpload::make('avatar')
                    ->label('الصورة الشخصية للعميل أو شعار جهة العمل')
                    ->directory('uploads/avatars')
                    ->image()
                    ->nullable()
                    ->imageEditor()
                    ->maxSize(20971520),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('الوظيفة'),

                Tables\Columns\TextColumn::make('opinion')
                    ->label('الرأي')
                    ->limit(100),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerReviews::route('/'),
            'create' => Pages\CreateCustomerReview::route('/create'),
            'edit' => Pages\EditCustomerReview::route('/{record}/edit'),
        ];
    }
}
