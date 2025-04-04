<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSectionResource\Pages;
use App\Models\NewsletterSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NewsletterSectionResource extends Resource
{
    protected static ?string $model = NewsletterSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 12; 

    public static function getNavigationLabel(): string
    {
        return 'قسم اشتراك النشرة البريدية';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('main_title')
                    ->label('عنوان قسم الاشتراك في النشرة البريدية')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('وصف بسيط عن قسم الاشتراك في النشرة البريدية')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة معبره عن دور القسم وهويته')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->columnSpanFull()
                    ->maxSize(20971520),

                Forms\Components\TextInput::make('cta_button_text')
                    ->label('نص الزر في قسم الاشتراك في النشرة البريدية - مثل: اشترك الأن')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')
                    ->label('عنوان القسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('وصف القسم')
                    ->limit(50),

                Tables\Columns\TextColumn::make('cta_button_text')
                    ->label('نص الزر'),
            ])
            ->filters([])
                    ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
        ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterSections::route('/'),
            'create' => Pages\CreateNewsletterSection::route('/create'),
            'edit' => Pages\EditNewsletterSection::route('/{record}/edit'),
        ];
    }
}
