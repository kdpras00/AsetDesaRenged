<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\KepalaDesa\DashboardController as KepalaDasaDashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('public.layanan');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('public.stats');

// Profile Routes
Route::prefix('profil')->name('profile.')->group(function () {
    Route::get('/sejarah', [HomeController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [HomeController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur', [HomeController::class, 'struktur'])->name('struktur');
    Route::get('/peta', [HomeController::class, 'peta'])->name('peta');
});
Route::get('/verify', [VerificationController::class, 'index'])->name('verification.index');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/verify/{hash}', [VerificationController::class, 'verifyByHash'])
    ->middleware('throttle:10,1')
    ->name('verification.verify.hash');
Route::get('/captcha/refresh', [VerificationController::class, 'refreshCaptcha'])->name('captcha.refresh');
Route::post('/verify/captcha', [VerificationController::class, 'submitCaptcha'])->name('verification.captcha.submit');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

});

Route::middleware('auth')->group(function () {
    Route::get('/notifications/count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.count');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.readAll');


    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'password'])->name('profile.password');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Operator routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');
    
    // Asset management routes
    Route::resource('assets', \App\Http\Controllers\Operator\AssetController::class);
    // Loan management
    Route::get('/loans', [\App\Http\Controllers\Operator\LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans/{loan}/approve', [\App\Http\Controllers\Operator\LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [\App\Http\Controllers\Operator\LoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/return', [\App\Http\Controllers\Operator\LoanController::class, 'markreturned'])->name('loans.return');
    // Letter processing
    Route::get('/letters', [\App\Http\Controllers\Operator\LetterController::class, 'index'])->name('letters.index');
    Route::get('/letters/{letter}/process', [\App\Http\Controllers\Operator\LetterController::class, 'show'])->name('letters.show');
    // Route::get('/letters/{letter}/process', function () {
    //    return redirect()->route('operator.letters.index');
    // });
    Route::post('/letters/{letter}/process', [\App\Http\Controllers\Operator\LetterController::class, 'process'])->name('letters.process');
    Route::post('/letters/{letter}/reject', [\App\Http\Controllers\Operator\LetterController::class, 'reject'])->name('letters.reject');
    Route::get('/letters/{letter}/download', [\App\Http\Controllers\Operator\LetterController::class, 'download'])->name('letters.download');
    
    // User management
    Route::resource('users', \App\Http\Controllers\Operator\UserController::class);
});

// Warga routes
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
    
    // Loan requests
    Route::get('/loans', [\App\Http\Controllers\Warga\LoanRequestController::class, 'index'])->name('loans.index');
    Route::get('/loans/create/{asset}', [\App\Http\Controllers\Warga\LoanRequestController::class, 'create'])->name('loans.create');
    Route::post('/loans', [\App\Http\Controllers\Warga\LoanRequestController::class, 'store'])->name('loans.store');
    // Letter requests
    Route::get('/letters', [\App\Http\Controllers\Warga\LetterRequestController::class, 'index'])->name('letters.index');
    Route::get('/letters/create/{type}', [\App\Http\Controllers\Warga\LetterRequestController::class, 'create'])->name('letters.create');
    Route::post('/letters', [\App\Http\Controllers\Warga\LetterRequestController::class, 'store'])->name('letters.store');
    Route::post('/loans/{loan}/return', [\App\Http\Controllers\Warga\LoanRequestController::class, 'return'])->name('loans.return');
    Route::get('/letters/{letter}/download', [\App\Http\Controllers\Warga\LetterRequestController::class, 'download'])->name('letters.download');
});

// Kepala Desa routes
Route::middleware(['auth', 'role:kepala_desa'])->prefix('kepala-desa')->name('kepala-desa.')->group(function () {
    Route::get('/dashboard', [KepalaDasaDashboardController::class, 'index'])->name('dashboard');
    
    // Letter verification
    Route::get('/letters', [\App\Http\Controllers\KepalaDesa\LetterVerificationController::class, 'index'])->name('letters.index');
    Route::get('/letters/{letter}', [\App\Http\Controllers\KepalaDesa\LetterVerificationController::class, 'show'])->name('letters.show');
    Route::post('/letters/{letter}/verify', [\App\Http\Controllers\KepalaDesa\LetterVerificationController::class, 'verify'])->name('letters.verify');
    Route::post('/letters/{letter}/reject', [\App\Http\Controllers\KepalaDesa\LetterVerificationController::class, 'reject'])->name('letters.reject');
    // Report routes
    Route::get('/reports', [\App\Http\Controllers\KepalaDesa\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print-assets', [\App\Http\Controllers\KepalaDesa\ReportController::class, 'printAssets'])->name('reports.print-assets');
    Route::get('/reports/print-loans', [\App\Http\Controllers\KepalaDesa\ReportController::class, 'printLoans'])->name('reports.print-loans');
    Route::get('/reports/print-letters', [\App\Http\Controllers\KepalaDesa\ReportController::class, 'printLetters'])->name('reports.print-letters');
});
