<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {
        Route::get('/', function () {
            return Inertia::render('Views/Matches');
        })->name('list');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'],function () {
        Route::get('/', function () {
            return Inertia::render('Views/Profile');
        })->name('view');
    });

    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'],function () {
        Route::get('/', function () {
            return Inertia::render('Views/Transactions');
        })->name('list');
    });

});
