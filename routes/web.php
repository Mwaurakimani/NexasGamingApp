<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', function () {
        $role = Auth::user()->role->name;

        //create a match condition for Guest,Player,Moderator,Admin and super Admin
        $matchCondition = ['Guest', 'Player', 'Moderator', 'Admin', 'Super Admin'];

        //check if the user's role matches any of the conditions
        if (in_array($role, $matchCondition)) {
            return match ($role) {
                'Player', 'Guest' => Inertia::render('Views/Dashboard'),
                'Moderator' => Inertia::render('Views/Moderator/Dashboard'),
                'Admin' => Inertia::render('Views/Admin/Dashboard'),
                'Super Admin' => Inertia::render('Views/Super/Dashboard'),
                default => redirect('/')->with('error', 'You do not have permission to access this page.'),
            };
        } else {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }
    })->name('dashboard');

    include_once "Dashboard/index.php";
});
