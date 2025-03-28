<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultantResource\Pages;
use App\Models\Consultant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultantResource extends Resource
{
    protected static ?string $model = Consultant::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'أقسام صفحة من نحن';

    public static function getNavigationLabel(): string
    {
        return 'اضافة المستشارين';
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
            'index' => Pages\ListConsultants::route('/'),
            'create' => Pages\CreateConsultant::route('/create'),
            'edit' => Pages\EditConsultant::route('/{record}/edit'),
        ];
    }
}
