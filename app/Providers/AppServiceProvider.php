<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Хук before для Gate - проверяется ДО всех политик
        // Модератор может делать ВСЁ
        Gate::before(function ($user, $ability) {
            if ($user && $user->isModerator()) {
                return true; // Модератор имеет доступ ко всем действиям
            }
        });
    }
}
