<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/password-reset', function () {
    return Inertia::render('Auth/ForgotPassword');
});