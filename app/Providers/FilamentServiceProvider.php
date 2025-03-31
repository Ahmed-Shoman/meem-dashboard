<?php

namespace App\Providers;

use App\Filament\Resources\ProgramResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class FilamentServiceProvider extends ServiceProvider
{


public function boot()
{
    Filament::serving(function () {
        $user = auth()->user();

        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            Filament::registerNavigationGroups([
                NavigationGroup::make()->label('إدارة المستخدمين')->collapsed(),
                NavigationGroup::make()->label('إدارة البرامج')->collapsed(),
            ]);

            Filament::registerNavigationItems([
                NavigationItem::make('المستخدمين')
                    ->icon('heroicon-o-users')
                    ->url(fn() => UserResource::getUrl('index'))
                    ->group('إدارة المستخدمين'),

                NavigationItem::make('البرامج')
                    ->icon('heroicon-o-folder')
                    ->url(fn() => ProgramResource::getUrl('index'))
                    ->group('إدارة البرامج'),
            ]);
        }
    });
}

}
