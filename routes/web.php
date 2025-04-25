<?php

    use Inertia\Inertia;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Platform\System\ChallengeController;
    use App\Http\Controllers\ArcadeGamesController\Chess\ChessController;

    Route::get('/', fn() => Inertia::render('Home'))->name('home');

    Route::get('/password-reset', fn() => Inertia::render('Auth/ForgotPassword'));

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        include_once __DIR__ . '/Dashboard/index.php';
    });

    // Authenticated user routes
    Route::middleware(['auth', 'verified'])->group(function () {

        // Challenge browsing and filtering
        Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
        Route::get('/challenges/chess/{id}', [ChallengeController::class,'viewChess'])->name('chess.challenges');
        Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');

        Route::get('/games/chess/{id}', [ChessController::class,'index'])->name('game.chess.index');

    });
