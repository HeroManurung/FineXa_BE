<?php

use Illuminate\Support\Facades\Route;

// Memanggil semua Controller
use App\Http\Controllers\AssetController;
use App\Http\Controllers\FinancialProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KuesionerController; 
use App\Http\Controllers\AnalisisController; 
use App\Http\Controllers\FaqController; 
use App\Http\Controllers\PasswordResetController;

// Halaman awal / Landing Page bawaan Laravel
Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// 1. AREA TAMU (Sekarang Bebas Akses Tanpa Satpam Guest!)
// ==========================================
    
// Form & Proses Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Form & Proses Register Web
Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register']);

// 1. Tampilkan Halaman Form Isi Email
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.request');
// 2. Proses Kirim Link ke Email (POST)
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');
// 3. Tampilkan Halaman Form Ketik Password Baru
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');
// 4. Proses Update Password ke Database (POST)
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.update');


// ==========================================
// 2. AREA DALAM GEDUNG (Auth) - Wajib Login
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Pintu Keluar (Logout)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// AREA PRESENTASI BLADE DOSEN (Awalan /web)
// ==========================================
    Route::prefix('web')->group(function () {
        
        // Dashboard / Analisis Investor
        Route::get('/analisis', [AnalisisController::class, 'index']);

        // Kuesioner Investor
        Route::get('/kuesioner', [KuesionerController::class, 'index']);
        Route::post('/kuesioner', [KuesionerController::class, 'simpan']);

        // Assets CRUD (Pakai resource agar ringkas 1 baris)
        Route::resource('assets', AssetController::class);

        // Users CRUD
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/create', function () { return view('users.create'); });
        Route::post('/users', [UserController::class, 'store']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::get('/users/{id}', [UserController::class, 'show']);   // Untuk lihat detail user
        Route::put('/users/{id}', [UserController::class, 'update']); // Untuk proses edit user

        // Profiles Finansial (Hanya Baca & Hapus, tidak ada Edit/Update!)
        Route::get('/profiles', [FinancialProfileController::class, 'index']);
        Route::get('/profiles/{id}', [FinancialProfileController::class, 'show']);
        Route::delete('/profiles/{id}', [FinancialProfileController::class, 'destroy']);

        // FAQs CRUD Lengkap
        Route::get('/faqs', [FaqController::class, 'index']);
        Route::get('/faqs/create', [FaqController::class, 'create']);
        Route::post('/faqs', [FaqController::class, 'store']);
        Route::get('/faqs/{id}', [FaqController::class, 'show']);
        Route::get('/faqs/{id}/edit', [FaqController::class, 'edit']);
        Route::put('/faqs/{id}', [FaqController::class, 'update']);
        Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);

    });
});