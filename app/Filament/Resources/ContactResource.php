<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    // تغيير الاسم في القائمة الجانبية إلى "تواصل معنا"

    // تغيير الاسم الجمعي
    protected static ?string $pluralLabel = 'رسائل التواصل';

    // تغيير الاسم المفرد
    protected static ?string $singularLabel = 'رسالة تواصل';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('الموضوع')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->label('الاسم الأول')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('الاسم الأخير')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('الرسالة')
                    ->required()
                    ->rows(5),
                Forms\Components\TextInput::make('phone_number')
                    ->label('رقم الجوال')
                    ->tel()
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')->label('الموضوع')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('first_name')->label('الاسم الأول')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label('الاسم الأخير')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                Tables\Columns\TextColumn::make('phone_number')->label('رقم الهاتف'),
                Tables\Columns\TextColumn::make('message')->label('الرسالة')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}