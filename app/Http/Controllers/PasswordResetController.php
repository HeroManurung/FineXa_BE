<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    
    // 1. Fungsi untuk nampilin halaman "Masukkan Email"
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Fungsi untuk nampilin halaman "Ketik Password Baru"
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // 1. KIRIM LINK RESET (HYBRID)
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        // JIKA SUKSES MENGIRIM EMAIL
        if ($status == Password::RESET_LINK_SENT) {
            
            // Jalur API (React)
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'success',
                    'pesan' => 'Link reset password telah dikirim ke email Anda!'
                ]);
            }
            
            // Jalur Web (Blade)
            return back()->with('success', 'Link reset password telah dikirim ke email Anda!');
        }

        // JIKA GAGAL (Email tidak ditemukan)
        
        // Jalur API (React)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Maaf, email tersebut tidak terdaftar di sistem kami.'
            ], 400); 
        }

        // Jalur Web (Blade)
        return back()->withErrors(['email' => 'Maaf, email tersebut tidak terdaftar di sistem kami.']);
    }


    
    // 2. PROSES UBAH PASSWORD BARU (HYBRID)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed', 
                PasswordRule::min(6)->mixedCase()->symbols() 
            ],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.mixed' => 'Password baru harus ada huruf besar & kecil.',
            'password.symbols' => 'Password baru harus mengandung simbol.'
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        // JIKA SUKSES RESET PASSWORD
        if ($status == Password::PASSWORD_RESET) {
            
            // Jalur API (React)
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'success',
                    'pesan' => 'Selamat! Password Anda berhasil diperbarui.'
                ]);
            }

            // Jalur Web (Blade)
            return redirect('/login')->with('success', 'Selamat! Password berhasil diperbarui. Silakan login kembali.');
        }

        // JIKA GAGAL (Token expired / salah)

        // Jalur API (React)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Maaf, link reset tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        // Jalur Web (Blade)
        return back()->withErrors(['email' => 'Maaf, link reset tidak valid atau sudah kedaluwarsa.']);
    }
}