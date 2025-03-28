<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\NewProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewProgramResource extends Resource
{
    protected static ?string $model = NewProgram::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'برامج ميم';

    public static function getNavigationLabel(): string
    {
        return 'اضافة البرامج';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('اسم وعنوان البرنامج')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('producer')
                    ->label('اسم المقدمه / المقدمة للبرنامج')
                    ->required(),


                Forms\Components\Textarea::make('description')
                    ->label('وصف مفصل عن البرنامج وما يقدمه')
                    ->columnSpanFull(),


                Forms\Components\FileUpload::make('image')
                    ->label('ارفاق صورة الغلاف الخارجي للبرنامج')
                    ->image()
                    ->required()
                    ->maxSize(20971520),

                // ✅ Repeater for Category (Stored as JSON)
                Forms\Components\Repeater::make('category')
                    ->label('نوع البرنامج')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('أكتب النوع المناسب للبرنامج')
                            ->required(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),


                Forms\Components\TextInput::make('seasons')
                    ->label('عدد مواسم البرنامج')
                    ->numeric(),

                Forms\Components\TextInput::make(name: 'episodes')
                    ->label('عدد حلقات البرنامج')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('اسم البرنامج')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('النوع')
                    ->limit(50),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('عدد المواسم')
                    ->sortable(),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('عدد الحلقات')
                    ->sortable(),

                Tables\Columns\TextColumn::make('producer')
                    ->label('اسم المقدمه / المقدمه')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الاضافة')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
