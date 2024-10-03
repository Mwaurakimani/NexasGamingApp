<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {

    $to = 'kimmwaus@gmail.com';                        // Recipient's email address
    $subject = 'Test Email';                           // Email subject
    $message = 'This is a test email sent using PHP.'; // Email body
    $headers = 'From: sender@example.com' . "\r\n" . // Sender's email address
        'Reply-To: kimmwaus@gmail.com' . "\r\n" . // Reply-to address
        'X-Mailer: PHP/' . phpversion(); // Optional header

    dd(mail($to, $subject, $message, $headers));

    return Inertia::render('Welcome');
});

Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include_once "Dashboard/index.php";
});
