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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

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
            Forms\Components\Textarea::make('content')
                ->label('محتوى النشرة')
                ->rows(6)
                ->required()
                ->columnSpan('full'),

            Forms\Components\Repeater::make('items')
                ->label('الصور والروابط')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('صورة النشرة')
                        ->image()
                        ->directory('newsletter-images')
                        ->required(),

                    Forms\Components\TextInput::make('link')
                        ->label('رابط')
                        ->url()
                        ->required(),
                ])
                ->minItems(1)
                ->columns(1)
                ->columnSpanFull(),
        ])
        ->action(function (array $data) {
            try {
                $emails = NewsletterMails::pluck('email');

                foreach ($emails as $email) {
                    foreach ($data['items'] as $item) {
                        Mail::to($email)->send(
                            new Newsletter(
                                content: $data['content'],
                                image: $item['image'],
                                link: $item['link']
                            )
                        );
                    }
                }

                Notification::make()
                    ->title('تم الإرسال بنجاح')
                    ->success()
                    ->body('تم إرسال جميع النشرات بنجاح إلى كل المشتركين.')
                    ->send();

            } catch (\Exception $e) {
                Notification::make()
                    ->title('فشل الإرسال')
                    ->danger()
                    ->body('حدث خطأ أثناء الإرسال: ' . $e->getMessage())
                    ->send();
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
