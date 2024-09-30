<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\TransactionsController;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {
        Route::get('/MyMatches',[MatchesController::class,'MyMatches'])->name('MyMatches');
        Route::get('/{id}',[MatchesController::class,'OpenMatches'])->where('id', '[0-9]+')->name('view_match');
        Route::get('/',[MatchesController::class,'ListMatches'])->name('list');

        Route::post('/joinMatch',[MatchesController::class,'joinMatch'])->name('joinMatch');
        Route::post('/postResults/{match}',[MatchesController::class,'postResults'])->name('postResults');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'],function () {
        Route::get('/', [UserController::class,'view_current_user_profile'])->name('view');
        Route::post('/updateAccount', [UserController::class,'update_current_user_profile'])->name('updateAccount');
        Route::post('/updateSecurity', [UserController::class,'update_current_user_password'])->name('updateSecurity');
    });

    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'],function () {
        Route::get('/', [TransactionsController::class,'list_transactions'])->name('list');
        Route::get('/deposits', [TransactionsController::class,'list_deposits'])->name('list_deposits');
        Route::get('/withdrawals', [TransactionsController::class,'list_withdrawals'])->name('list_withdrawals');
        Route::post('/deposit', [TransactionsController::class,'deposit'])->name('deposit');
        Route::post('/withdraw', [TransactionsController::class,'withdraw'])->name('withdraw');
        Route::post('/confirmWithdrawal', [TransactionsController::class,'confirmWithdrawal'])->name('confirmWithdrawal');
    });

});
