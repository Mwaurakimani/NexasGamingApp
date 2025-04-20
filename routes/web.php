<?php

    use Inertia\Inertia;
    use Illuminate\Support\Facades\Route;

    Route::get('/', fn() => Inertia::render('Home'));

    Route::get('/password-reset', fn() => Inertia::render('Auth/ForgotPassword'));

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        include_once __DIR__ . '/Dashboard/index.php';
    });
