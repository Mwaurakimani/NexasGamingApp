<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
    public function boot():  void
    {
        Schema::defaultStringLength(191);

        $this->loadMigrationsFrom([
            database_path('migrations/System'),
            database_path('migrations/users'),
            database_path('migrations/Matches'),
            database_path('migrations/Transaction'),
        ]);
    }
}
