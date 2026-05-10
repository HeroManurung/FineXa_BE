<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\FinancialProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// ==========================================
// AREA VIP (Wajib Login / Dijaga Sanctum)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Cek User & Analisis
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/analisis', [AnalisisController::class, 'index']);
    
    // 2. Kuesioner (Investor)
    Route::get('/kuesioner', [KuesionerController::class, 'index']);
    Route::post('/kuesioner', [KuesionerController::class, 'simpan']);

    // 3. Kelola FAQ (Admin)
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{id}', [FaqController::class, 'update']);
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);

    // 4. Kelola Asset (Admin) - Dipindah ke sini!
    Route::post('/assets', [AssetController::class, 'store']);
    Route::put('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

    // 5. Kelola User (Admin) - Dipindah ke sini!
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // 6. Kelola Profil Finansial (Admin) - Rute store & update dihapus!
    Route::get('/financial-profiles', [FinancialProfileController::class, 'index']);
    Route::get('/financial-profiles/{id}', [FinancialProfileController::class, 'show']);
    Route::delete('/financial-profiles/{id}', [FinancialProfileController::class, 'destroy']);

    // Rute untuk ReactJS membuang Token
    Route::post('/logout', [LoginController::class, 'logout']);

});


// ==========================================
// AREA PUBLIK (Bebas Diakses Tanpa Login)
// ==========================================

// Investor (yang belum login) boleh lihat-lihat daftar aset investasi
Route::get('/assets', [AssetController::class, 'index']);
Route::get('/assets/{id}', [AssetController::class, 'show']);

// Investor (yang belum login) boleh baca-baca FAQ
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/faqs/{id}', [FaqController::class, 'show']);

// Rute untuk ReactJS mendapatkan Token
Route::post('/login', [LoginController::class, 'authenticate']);

// minta kirim link reset ke email (Request link)
Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLink']);
// ngirim password baru (Resetting)
Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword']);

// Rute pendaftaran user baru via API
Route::post('/register', [RegisterController::class, 'register']);