<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\DashboardController;

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin + Super Admin access
    Route::middleware(['auth', 'role:Admin,Super Admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    });
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::prefix('admin')->middleware(['auth', 'role:Admin,Super Admin'])->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    });

