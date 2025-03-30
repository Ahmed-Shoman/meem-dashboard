<?php

namespace App\Providers;

use App\Filament\Resources\ProgramResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;


class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::serving(function () {
            $user = auth()->user();

            if ($user->isAdmin()) {
                // الـ Admin يرى الشريط الجانبي مع كل العناصر
                Filament::registerNavigationGroups([
                    NavigationGroup::make()
                        ->label('إدارة المستخدمين')
                        ->collapsed(),
                    NavigationGroup::make()
                        ->label('إدارة البرامج')
                        ->collapsed(),
                ]);

                Filament::navigation(function (NavigationBuilder $builder) {
                    $builder->items([
                        NavigationItem::make('المستخدمين')
                            ->icon('heroicon-o-users')
                            ->url(fn () => UserResource::getUrl('index'))
                            ->group('إدارة المستخدمين'),
                        NavigationItem::make('البرامج')
                            ->icon('heroicon-o-folder')
                            ->url(fn () => ProgramResource::getUrl('index'))
                            ->group('إدارة البرامج'),
                    ]);
                });
            } else {
                // المستخدم العادي لا يرى الشريط الجانبي
                Filament::navigation(function (NavigationBuilder $builder) {
                    $builder->items([]); // لا عناصر في الشريط الجانبي
                });
            }


            Filament::registerStyles([
            asset('css/filament.css'),
]);
        });
    }
}