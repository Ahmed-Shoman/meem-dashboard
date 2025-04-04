<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    // protected static ?string $navigationGroup = 'أقسام الواجهة الاماميه';

    protected static ?int $navigationSort = 9; 
    protected static ?string $pluralLabel = 'طلبات التواصل';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('الموضوع')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('first_name')
                    ->label('الاسم الأول')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('last_name')
                    ->label('الاسم الأخير')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('message')
                    ->label('الرسالة')
                    ->required()
                    ->columnSpanFull()
                    ->rows(5),
                Forms\Components\TextInput::make('phone_number')
                    ->label('رقم الجوال')
                    ->columnSpanFull()
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
            if (!auth()->user() || !auth()->user()->is_admin) {
        abort(403, 'Unauthorized');
    }
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}