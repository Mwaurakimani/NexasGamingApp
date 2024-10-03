<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

//$resp = Mail::to('aerissat@gmail.com')->send(new TestEmail());


Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware(['guest'])->group(function () {
    include_once "guest/index.php";
});


Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include_once "Dashboard/index.php";
});
