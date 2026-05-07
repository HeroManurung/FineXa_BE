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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('web')->group(function () {
    
    // 1. Assets CRUD 
    Route::resource('assets', AssetController::class);

    // 3. Profiles (Hanya Read dan Update, karena Create/Delete mengikuti User)
    Route::get('/profiles', [FinancialProfileController::class, 'index']);
    Route::get('/profiles/{id}/edit', [FinancialProfileController::class, 'edit']);
    Route::put('/profiles/{id}', [FinancialProfileController::class, 'update']);

    // 4. Users (Read dan Create)
    Route::get('/users', [UserController::class, 'index']);
    
    // Jalan pintas untuk menampilkan view form registrasi tanpa perlu menambah fungsi di Controller
    Route::get('/users/create', function () {return view('users.create'); });
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/users', [UserController::class, 'store']);

    // RUTE DASHBOARD / ANALISIS INVESTOR
    Route::get('/analisis', [AnalisisController::class, 'index']);
});

// 1. Jalur untuk menampilkan halaman form (Pintu Depan)
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    // 2. Jalur untuk memproses isian form (Menyerahkan KTP ke Satpam)
    Route::post('/login', [LoginController::class, 'authenticate']);

    // 3. Jalur untuk keluar dari sistem (Mengembalikan Kartu Akses)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // RUTE REGISTER WEB
    Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
    Route::post('/register', [RegisterController::class, 'register']);

    // RUTE KUESIONER
    Route::get('/web/kuesioner', [KuesionerController::class, 'index']);
    Route::post('/web/kuesioner', [KuesionerController::class, 'simpan']);

    // Rute untuk Admin mengelola FAQ
    Route::get('/faqs', [FaqController::class, 'index']);
   
    // Rute untuk menerima email dari halaman ReactJS tadi
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
    
    // Rute untuk memproses perubahan password baru
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
