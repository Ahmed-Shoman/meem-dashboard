<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderResource\Pages;
use App\Filament\Resources\HeaderResource\RelationManagers;
use App\Models\Header;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeaderResource extends Resource
{
    protected static ?string $model = Header::class;
    protected static ?string $navigationIcon = 'heroicon-o-numbered-list';
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('uploads/logos')
                            ->preserveFilenames()
                            ->columnSpanFull()
                            ->live()
                            ->visibility('public')
                            ->maxSize(20971520),


                        // Forms\Components\Repeater::make('links')
                        //     ->label('Navigation Links')
                        //     ->schema([
                        //         Forms\Components\TextInput::make('text')
                        //             ->label('Link Text')
                        //             ->required()
                        //             ->columnSpanFull(),


                        //     ])
                        //     ->collapsible()
                        //     ->columns(1) // جعل كل الإدخالات في سطر واحد

                        //     ->columnSpanFull(), // جعل الحقل يأخذ العرض بالكامل

                        // Forms\Components\TextInput::make('cta_text')
                        //     ->label('CTA Button Text')
                        //     ->required()
                        //     ->columnSpanFull(),


                    ])
                    ->columns(1), // يجعل كل العناصر تحت بعضها مباشرة
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo'),

                // Tables\Columns\TextColumn::make('cta_text')
                //     ->label('CTA Button Text'),

                // Tables\Columns\TextColumn::make('cta_link')
                //     ->label('CTA Button Link')
                //     ->limit(30),

                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Created At')
                //     ->dateTime()
                //     ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeaders::route('/'),
            'create' => Pages\CreateHeader::route('/create'),
            'edit' => Pages\EditHeader::route('/{record}/edit'),
        ];
    }
}
