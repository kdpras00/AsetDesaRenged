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
Route::get('/verify', [VerificationController::class, 'index'])->name('verification.index');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Operator routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');
    
    // Asset management routes will be added here
    // Loan approval routes will be added here
    // Letter processing routes will be added here
    
    // User management
    Route::resource('users', \App\Http\Controllers\Operator\UserController::class);
});

// Warga routes
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
    
    // Loan request routes will be added here
    // Letter request routes will be added here
});

// Kepala Desa routes
Route::middleware(['auth', 'role:kepala_desa'])->prefix('kepala-desa')->name('kepala-desa.')->group(function () {
    Route::get('/dashboard', [KepalaDasaDashboardController::class, 'index'])->name('dashboard');
    
    // Letter verification routes will be added here
    // Report routes will be added here
});
