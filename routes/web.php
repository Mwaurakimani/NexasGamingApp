<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include_once "Dashboard/index.php";
});
