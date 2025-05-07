<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\TrackUserLogin;
use Illuminate\Auth\Events\Logout;
use App\Listeners\TrackUserLogout;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        Login::class => [
            TrackUserLogin::class,
        ],
        Logout::class => [
            TrackUserLogout::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
