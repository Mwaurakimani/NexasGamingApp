<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Platform\Game\GameController;
    use App\Http\Controllers\Platform\User\AccountController;
    use App\Http\Controllers\Platform\Match\MatchesController;
    use App\Http\Controllers\Platform\Wallet\WalletController;
    use App\Http\Controllers\Platform\Match\MatchLogController;
    use App\Http\Controllers\Platform\Match\MatchTypeController;
    use App\Http\Controllers\Platform\Wallet\TransactionController;
    use App\Http\Controllers\DashboardsControllers\DashboardController;
    use App\Http\Controllers\Platform\Match\MatchParticipantController;
    use App\Http\Controllers\Admin\UsersController as AdminUsersController;

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['auth', 'role:Admin,Super Admin'])
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {
             Route::resource('users', AdminUsersController::class)
                  ->only(['index', 'show', 'edit', 'update'])
                  ->names([
                              'index'  => 'users',
                              'show'   => 'users.show',
                              'edit'   => 'users.edit',
                              'update' => 'users.update',
                          ]);
         });

    Route::middleware(['auth'])->group(function () {
        Route::resource('profile', AccountController::class)
             ->only(['index', 'edit', 'update'])
             ->parameters(['profile' => '']) // 👈 This disables the route param
             ->names([
                         'index'  => 'account.profile',
                         'edit'   => 'account.profile.edit',
                         'update' => 'account.profile.update',
                     ]);

        // Add this inside the auth group
        Route::get('/account/password/edit', [AccountController::class, 'editPassword'])->name('account.password.edit');
        Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
        Route::delete('/account/disable', [AccountController::class, 'disable'])->name('account.profile.disable');

    });


    Route::resource('games', GameController::class)->only(['index', 'show']);
    Route::resource('match-types', MatchTypeController::class)->only(['index', 'show']);
    Route::resource('matches', MatchesController::class);
    Route::resource('match-participants', MatchParticipantController::class)->only(['store', 'update']);
    Route::resource('match-logs', MatchLogController::class)->only(['store']);
    Route::resource('wallets', WalletController::class)->only(['index', 'show']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'store']);


    include_once "chessMechanics.php";







