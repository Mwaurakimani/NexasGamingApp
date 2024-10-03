<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {

//    $to = 'recipient@example.com'; // Recipient's email address
//    $resp = Mail::to('kimmwaus@gmail.com')->send(new TestEmail());
//    dd($resp);

//    dd("hi");

    return Inertia::render('Welcome');
});

Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include_once "Dashboard/index.php";
});
