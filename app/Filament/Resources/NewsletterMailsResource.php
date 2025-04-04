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

class NewsletterMailsResource extends Resource
{
    protected static ?string $model = NewsletterMails::class;

    protected static ?string $navigationLabel = 'النشرات البريدية';
    protected static ?string $navigationGroup = 'Meem Articles Section';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required()
                ->unique(NewsletterMails::class, 'email'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('created_at')->label('تاريخ الاشتراك')->dateTime(),
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
