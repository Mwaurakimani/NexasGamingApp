<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\Transactions\SystemTransactionsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {

        Route::post('/suspend_account/{id}', [UserController::class, 'suspend_account'])->name('suspend_account_action');
        Route::post('/unsuspend_account_action/{id}', [UserController::class, 'unsuspend_account_action'])->name('unsuspend_account_action');
        Route::get('/search_user_action', [UserController::class, 'search_user_action'])->name('search_user_action');

        Route::post('/update_password/{user}',[UserController::class,'update_password'])->where('id', '[0-9]+')->name('update_password');
        Route::get('/{id}',[UserController::class,'view_user'])->name('view_user');
        Route::post('/{id}',[UserController::class,'update_account'])->name('update_account');
        Route::get('/',[UserController::class,'list'])->name('list');

    });

    Route::group(['prefix' => 'admin_transactions', 'as' => 'admin_transactions.'],function () {
        Route::post('/generateTokens', [SystemTransactionsController::class,'generateTokens'])->name('generateTokens');
        Route::post('/seizeTokens', [SystemTransactionsController::class,'seizeTokens'])->name('seizeTokens');
    });

});
