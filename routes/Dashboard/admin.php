<?php

use App\Http\Controllers\MatchesController;
use App\Http\Controllers\Transactions\SystemTransactionsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {

        Route::get('/create_match',[MatchesController::class,'create'])->name('create_match');
        Route::post('/create_match',[MatchesController::class,'store'])->name('post_match_action');
        Route::put('/update_match/{match}',[MatchesController::class,'edit'])->name('put_match_action');
        Route::put('/update_match_event_action/{match}',[MatchesController::class,'eventEdit'])->name('put_match_event_action');
        Route::post('/get_user_by_name',[MatchesController::class,'get_user_by_name'])->name('get_user_by_name');
        Route::post('/addUserToMatch',[MatchesController::class,'addUserToMatch'])->name('addUserToMatch');


//        Route::post('/update_password/{user}',[UserController::class,'update_password'])->where('id', '[0-9]+')->name('update_password');
//        Route::get('/{id}',[UserController::class,'view_user'])->name('view_user');
//        Route::post('/{id}',[UserController::class,'update_account'])->name('update_account');

    });

    Route::group(['prefix' => 'admin_transactions', 'as' => 'admin_transactions.'],function () {
        Route::get('/', [TransactionsController::class,'list_transactions'])->name('list');
        Route::post('/transferTokens', [SystemTransactionsController::class,'transferTokens'])->name('transferTokens');

    });

});
