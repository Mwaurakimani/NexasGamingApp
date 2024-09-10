<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {
        Route::get('/',[MatchController::class,'ListMatches'])->name('list');
        Route::get('/{id}',[MatchController::class,'OpenMatches'])->name('view_match');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'],function () {
        Route::get('/', [UserController::class,'view_current_user_profile'])->name('view');
    });

    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'],function () {
        Route::get('/', [TransactionsController::class,'list_transactions'])->name('list');
    });

});
