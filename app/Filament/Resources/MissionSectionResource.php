<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MissionSectionResource\Pages;
use App\Filament\Resources\MissionSectionResource\Pages\CreateMissionSection;
use App\Filament\Resources\MissionSectionResource\Pages\EditMissionSection;
use App\Filament\Resources\MissionSectionResource\Pages\ListMissionSections;
use App\Models\MissionSection;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MissionSectionResource extends Resource
{
    protected static ?string $model = MissionSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';
    protected static ?string $navigationGroup = 'أقسام صفحة من نحن';
    protected static ?string $label = 'Mission Section';

    public static function getNavigationLabel(): string
    {
        return 'مهام وأدوار ميم';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('main_title')
                    ->label('العنوان الاساسي لقسم مهمة ودور وروية ميم')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('الوصف للعنوان الاساسي لقسم المهام والادوار')
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('points')
                    ->label('أدوار ومهام التي تقدمها ميم')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('رقم الدور - يرجي الالتزام بالترتيب وايضا الصيغه مثل: 01 - 02 - 03')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('title')
                            ->label('عنوان الدور أو المهمه او الرؤيه او الرساله')
                            ->required(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('عنوان صغير عن معني الدور - الرساله - الرؤيه')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('وصف مفصل عن الدور - الرؤيه - الرساله'),

                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('title2')
                    ->label('العنوان الثاني في قسم مهام ميم ')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description2')
                    ->label('وصف بسيط للعنوان الثاني في قسم مهام ميم')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')
                    ->label('العنوان')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الانشاء')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMissionSections::route('/'),
            'create' => Pages\CreateMissionSection::route('/create'),
            'edit' => Pages\EditMissionSection::route('/{record}/edit'),
        ];
    }
}
