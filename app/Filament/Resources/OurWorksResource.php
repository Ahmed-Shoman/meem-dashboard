<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OurWorksResource\Pages;
use App\Models\OurWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OurWorksResource extends Resource
{
    protected static ?string $model = OurWork::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'الصفحة الرئيسية';

    public static function getNavigationLabel(): string
    {
        return 'أعمالنا';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('قسم أعمالنا والاقسام التي تليه')
                ->schema([
                    Forms\Components\TextInput::make('main_title')
                        ->label('عنوان قسم أعمالنا')
                        ->required(),

                    Forms\Components\TextInput::make('subtitle')
                        ->label('وصف بسيط عن قسم أعمالنا'),

                    Forms\Components\Repeater::make('client_logos')
                        ->label('شعارات الشركات او الداعمين ')
                        ->schema([
                            Forms\Components\FileUpload::make('logo')
                                ->label('الشعار')
                                ->image()
                                ->required()
                                ->maxSize(20971520),
                        ])
                        ->collapsible()
                        ->columnSpanFull(),


                    Forms\Components\Textarea::make('description_text')
                        ->label('جملة معبرة عن أرقام ونجاحات ميم'),

                    Forms\Components\TextInput::make('listeners_stat')
                        ->label('عنوان احصائيات عدد المستعمين'),

                    Forms\Components\TextInput::make('listeners_stat_description')
                        ->label('وصف بسيط عن النجاح في زيادة أعداد المستعمين'),

                    Forms\Components\TextInput::make('episodes_stat')
                        ->label('عنوان عن احصائيات اعداد الحلقات'),

                    Forms\Components\TextInput::make('episodes_stat_description')
                        ->label('وصف بسيط معبر عن النجاح في زيادة أعداد وتنوع الحلقات'),

                    Forms\Components\TextInput::make('programs_stat')
                        ->label('عنوان عن احصائيات انواع البرامج'),

                    Forms\Components\TextInput::make('programs_stat_description')
                        ->label('وصف بسيط ومعبر عن النجاحات في البرامج والتعاقد مع مقدميمن متميزين'),

                    Forms\Components\TextInput::make('banner_text')
                        ->label('جملة قوية قبل قسم الحلقات لتجذب انتباه الزوار'),
                ])
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_title')->label('العنوان الاساسي للقسم')->searchable(),
                Tables\Columns\TextColumn::make('listeners_stat')->label('نجاحات المستمعين'),
                Tables\Columns\TextColumn::make('episodes_stat')->label('نجاحات الحلقات'),
                Tables\Columns\TextColumn::make('programs_stat')->label('نجاحات البرامج'),
                Tables\Columns\TextColumn::make('banner_text')->label('جملة قبل قسم الحلقات'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الاضافة')->dateTime()->sortable(),
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
            'index' => Pages\ListOurWorks::route('/'),
            'create' => Pages\CreateOurWorks::route('/create'),
            'edit' => Pages\EditOurWorks::route('/{record}/edit'),
        ];
    }
}
