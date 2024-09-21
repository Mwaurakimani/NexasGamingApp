<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::get('/',[UserController::class,'list'])->name('list');
        Route::get('/{id}',[UserController::class,'view_user'])->name('view_user');
        Route::post('/{id}',[UserController::class,'update_account'])->name('update_account');
        Route::post('/update_password/{user}',[UserController::class,'update_password'])->name('update_password');
    });

    Route::group(['prefix' => 'admin_transactions', 'as' => 'admin_transactions.'],function () {
        Route::get('/', [TransactionsController::class,'list_transactions'])->name('list');
    });

});
