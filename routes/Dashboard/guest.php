<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\Transactions\SystemTransactionsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {
        Route::get('/',[MatchesController::class,'ListMatches'])->name('list');
        Route::get('/{id}',[MatchesController::class,'OpenMatches'])->where('id', '[0-9]+')->name('view_match');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'],function () {
        Route::get('/', [UserController::class,'view_current_user_profile'])->name('view');
        Route::post('/updateAccount', [UserController::class,'update_current_user_profile'])->name('updateAccount');
        Route::post('/updateSecurity', [UserController::class,'update_current_user_password'])->name('updateSecurity');
    });

    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'],function () {
        Route::get('/', [TransactionsController::class,'list_transactions'])->name('list');
        Route::post('/deposit', [TransactionsController::class,'deposit'])->name('deposit');
    });

});
