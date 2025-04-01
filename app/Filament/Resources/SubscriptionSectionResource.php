<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionSectionResource\Pages;
use App\Models\SubscriptionSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionSectionResource extends Resource
{
    protected static ?string $model = SubscriptionSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';

    public static function getNavigationLabel(): string
    {
        return 'قسم خطط الاشتراك';
    }




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main Title
                Forms\Components\TextInput::make('main_title')
                    ->label('عنوان قسم الاشتراكات والخطط')
                    ->required()
                    ->columnSpanFull(),

                // Plans (Repeater)
                Forms\Components\Repeater::make('plan_details')
                    ->label('خطة الاشتراك معنا')
                    ->schema([
                        Forms\Components\TextInput::make('plan_name')
                            ->label('اسم الخطة')
                            ->required(),

                        Forms\Components\Textarea::make('plan_description')
                            ->label('وصف بسيط عن الخطة'),

                        Forms\Components\TextInput::make('plan_price')
                            ->label('سعر الاشتراك في الخطة')
                            ->required(),

                        Forms\Components\Repeater::make('feature_list')
                            ->label('مزايا التي سيحصل عليها المستخد عند الاشتراك في الخطه')
                            ->schema([
                                Forms\Components\Textarea::make('feature_list')
                                    ->label('الميزة: ')
                            ])
                            ->collapsible()
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),







                // FAQs Section (Repeater)
                Forms\Components\Repeater::make('faqs')
                    ->label('الاسئلة المتكررة')
                    ->schema([
                        Forms\Components\TextInput::make('question')
                            ->label('السؤال')
                            ->required(),

                        Forms\Components\Textarea::make('answer')
                            ->label('الاجابة')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                // Listen Now Section
                Forms\Components\Section::make('قسم استمع اليناالان')
                    ->schema([
                        Forms\Components\TextInput::make('listen_now_title')
                            ->label('عنوان قسم استمع الينا الان')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('listen_now_text')
                            ->label('وصف بسيط عن قسم استمع الينا الان')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('listen_now_image')
                            ->label('صورة القسم - استمع الينا الان')
                            ->image()
                            ->maxSize(20971520),

                        Forms\Components\Repeater::make('platform_links')
                            ->label('روابط المنصات التابعه لنا')
                            ->schema([
                                Forms\Components\TextInput::make('platform_name')
                                    ->label('اسم المنصه')
                                    ->required(),

                                Forms\Components\TextInput::make('platform_url')
                                    ->label('رابط البروفايل الخاص بنا علي المنصه')
                                    ->url()
                                    ->required(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')
                    ->label('عنوان قسم الاشتراكات')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan_name')
                    ->label('اسم الخطة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan_price')
                    ->label(' سعر الخطة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plan_description')
                    ->label(' وصف الخطة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الاضافة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionSections::route('/'),
            'create' => Pages\CreateSubscriptionSection::route('/create'),
            'edit' => Pages\EditSubscriptionSection::route('/{record}/edit'),
        ];
    }
}
