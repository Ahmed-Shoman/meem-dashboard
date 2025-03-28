<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioLibraryResource\Pages;
use App\Models\AudioLibrary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AudioLibraryResource extends Resource
{
    protected static ?string $model = AudioLibrary::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // تغيير الأيقونة لتطابق OurWorksResource
    protected static ?string $navigationGroup = 'برامج ميم';

    public static function getNavigationLabel(): string
    {
        return 'اضافة الحلقات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('قم باضافة الحلقات الي البرنامج الذي تريده:') 
                    ->schema([
                        Forms\Components\Select::make('program_id')
                            ->label('اختار البرنامج الذي تتبع له الحلقه')
                            ->relationship('program', 'program_name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Textarea::make('description')
                            ->label('عنوان الحلقه الاساسي')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الغلاف الخارجي للحلقة')
                            ->image()
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\FileUpload::make('sound')
                            ->label('ارفاق الملف الصوتي للحلقة')
                            ->acceptedFileTypes(['audio/*'])
                            ->nullable()
                            ->required()
                            ->maxSize(20971520),

                        Forms\Components\Textarea::make('sub_description')
                            ->label('وصف مفصل عن محتوي الحلقة')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sound_time')
                            ->label('مدة الحلقه - مثل: 20:20')
                            ->required(),

                        Forms\Components\TextInput::make('category')
                            ->label('نوع الحلقة - (دراما - رياضه - مغامرة - وثائقي)')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('حالة ظهور الحلقة - (تظهر - لا تظهر)')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.program_name')
                    ->label('برنامج الحلقة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label(label: 'نوع الحلقة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sound_time')
                    ->label('زمن الحلقة'),

                Tables\Columns\TextColumn::make('description')
                    ->label('عنوان الحلقة')
                    ->limit(50), 

                Tables\Columns\TextColumn::make('sub_description')
                    ->label('وصف الحلقة')
                    ->limit(50), // إضافة حد للتناسق

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean(), 

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ اضافة الحلقه')
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
            'index' => Pages\ListAudioLibraries::route('/'),
            'create' => Pages\CreateAudioLibrary::route('/create'),
            'edit' => Pages\EditAudioLibrary::route('/{record}/edit'),
        ];
    }
}
