<?php


$to = 'kimmwaus@gmail.com'; // Recipient's email address
$subject = 'Test Email'; // Email subject
$message = 'This is a test email sent using PHP.'; // Email body
$headers = 'From: sender@example.com' . "\r\n" . // Sender's email address
           'Reply-To: kimmwaus@gmail.com' . "\r\n" . // Reply-to address
           'X-Mailer: PHP/' . phpversion(); // Optional header

// Send the email
if(mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully.';
} else {
    echo 'Email sending failed.';
}
?>



die();
Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/userIsAuthenticated', function () {
    return ["status" => auth()->check()];
})->name('userIsAuthenticated');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(callback: function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    include_once "Dashboard/index.php";
});
