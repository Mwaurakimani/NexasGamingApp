<?php

    use Inertia\Inertia;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Platform\System\ChallengeController;

    Route::get('/', fn() => Inertia::render('Home'))->name('home');

    Route::get('/password-reset', fn() => Inertia::render('Auth/ForgotPassword'));

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
        include_once __DIR__ . '/Dashboard/index.php';
    });

    Route::middleware(['auth'])->get('/Challenges', function () {
        return Inertia::render('Challenges/Index');
    })->name('challenges');

    // Authenticated user routes
    Route::middleware(['auth', 'verified'])->group(function () {

        // Challenge browsing and filtering
        Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
        Route::get('/challenges/chess/{id}', fn() => Inertia::render('games/chess/ViewChallenge'))->name('chess.challenges');
        Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');


        Route::get('/games/chess/{id}', fn () => Inertia::render('games/chess/Index'))->name('game.chess.index');
    });
