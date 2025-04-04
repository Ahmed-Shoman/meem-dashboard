<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterMailsResource\Pages\CreateNewsletterMail;
use App\Filament\Resources\NewsletterMailsResource\Pages\CreateNewsletterMails;
use App\Filament\Resources\NewsletterMailsResource\Pages\EditNewsletterMail;
use App\Filament\Resources\NewsletterMailsResource\Pages\EditNewsletterMails;
use App\Filament\Resources\NewsletterMailsResource\Pages\ListNewsletterMails;
use App\Mail\Newsletter;
use App\Models\NewsletterMails;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class NewsletterMailsResource extends Resource
{
    protected static ?string $model = NewsletterMails::class;

    protected static ?string $navigationLabel = 'النشرات البريدية';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required()
                ->columnSpanFull()
                ->unique(NewsletterMails::class, 'email'),
        ]);
    }
public static function table(Table $table): Table
{
    // Check if the user is an admin
    if (!auth()->user() || !auth()->user()->is_admin) {
        abort(403, 'Unauthorized');
    }

    return $table
        ->columns([
            TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
            TextColumn::make('created_at')->label('تاريخ الاشتراك')->dateTime(),
        ])
        ->actions([
            ViewAction::make()
                ->label('عرض')
                ->icon('heroicon-s-eye'),
            EditAction::make()
                ->label('تعديل')
                ->icon('heroicon-s-pencil'),
            DeleteAction::make()
                ->label('حذف')
                ->icon('heroicon-s-trash')
                ->requiresConfirmation()
                ->color('danger'),
        ])
        ->bulkActions([
            BulkAction::make('sendNewsletter')
                ->label('إرسال نشرة بريدية')
                ->form([
                    Textarea::make('content')
                        ->label('محتوى النشرة')
                        ->rows(6)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $emails = NewsletterMails::pluck('email');
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new Newsletter($data['content']));
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('إرسال نشرة بريدية'),
        ]);
}


    public static function getPages(): array
    {
        return [
            'index' => ListNewsletterMails::route('/'),
            'create' => CreateNewsletterMails::route('/create'),
            'edit' => EditNewsletterMails::route('/{record}/edit'),
        ];
    }
}
