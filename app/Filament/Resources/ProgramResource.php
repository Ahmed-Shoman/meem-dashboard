<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';

    public static function getNavigationLabel(): string
    {
        return 'اضافة البرامج';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اضافة البرامج التابعة لقناة ميم')
                    ->schema([
                        Forms\Components\TextInput::make('program_name')
                            ->label('اسم البرنامج')
                            ->required(),

                        Forms\Components\TextInput::make('presenter')
                            ->label('اسم المقدم / المقدمة للبرنامج')
                            ->required(),

                        Forms\Components\FileUpload::make('presenter_image')
                            ->label('صورة مقدم البرنامج')
                            ->directory('uploads/presenters')
                            ->image()
                            ->nullable()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('instagram')
                            ->label('حساب انستجرام للمقدم')
                            ->placeholder('https://www.instagram.com/username')
                            ->url()
                            ->nullable(),

                        Forms\Components\TextInput::make('snapchat')
                            ->label('حساب سناب شات للمقدم')
                            ->placeholder('https://www.snapchat.com/add/username')
                            ->nullable()
                            ->url(),

                        Forms\Components\TextInput::make('x')
                            ->label('حساب اكس - تويتر للمقدم')
                            ->placeholder('https://twitter.com/username')
                            ->url()
                            ->nullable(),

                        Forms\Components\Textarea::make('program_description')
                            ->label('وصف مفصل عن البرنامج وما سيقدمه')
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الغلاف الخارجي للبرنامج')
                            ->directory('uploads/logos')
                            ->image()
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\TextInput::make('seasons')
                            ->label('عدد مواسم البرنامج')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('episodes')
                            ->label('عدد حلقات البرنامج')
                            ->numeric()
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('حالة البرنامج - (نشط - غير نشط)')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = Program::query();
                if (!auth()->user()->isAdmin()) {
                    $query->where('id', auth()->user()->program_id);
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('program_name')
                    ->label('اسم البرنامج')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('presenter')
                    ->label('مقدم البرنامج')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('presenter_image')
                    ->label('صورة مقدم البرنامج')
                    ->size(50),

                Tables\Columns\TextColumn::make('instagram')
                    ->label('انستجرام')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('snapchat')
                    ->label('سناب شات')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('x')
                    ->label('تويتر')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('seasons')
                    ->label('عدد المواسم'),

                Tables\Columns\TextColumn::make('episodes')
                    ->label('عدد الحلقات'),

                Tables\Columns\TextColumn::make('program_description')
                    ->label('وصف البرنامج')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('حالة النشاط')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الاضافة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => auth()->user()->isAdmin() || auth()->user()->program_id === $record->id),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => auth()->user()->can('delete', $record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->isAdmin()),
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

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
