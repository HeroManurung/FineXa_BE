<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        // 1. Validasi: Pastikan user benar-benar mengetik email
        $request->validate([
            'email' => 'required|email'
        ]);

        // 2. Suruh mesin Laravel mencari email tersebut dan mengirimkan link
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        // 3. Berikan jawaban ke ReactJS
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Link reset password telah dikirim ke email Anda!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'pesan' => 'Maaf, email tersebut tidak terdaftar di sistem kami.'
        ], 400); // 400 = Bad Request (Error)
    }
    public function resetPassword(Request $request)
    {
        // 1. Validasi Input dari React
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed', // Berarti butuh input 'password_confirmation' dari React
                PasswordRule::min(6)->mixedCase()->symbols() // Syarat dosen
            ],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.mixed' => 'Password baru harus ada huruf besar & kecil.',
            'password.symbols' => 'Password baru harus mengandung simbol.'
        ]);

        // 2. Jalankan Proses Reset di Database
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Proses update password & hapus token lama
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        // 3. Berikan Respon ke React
        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Selamat! Password Anda berhasil diperbarui.'
            ]);
        }

        // Jika token salah atau sudah kedaluwarsa
        return response()->json([
            'status' => 'error',
            'pesan' => 'Maaf, link reset tidak valid atau sudah kedaluwarsa.'
        ], 400);
    }
}