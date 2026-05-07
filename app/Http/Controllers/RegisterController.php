<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialProfile; // Sesuaikan jika nama modelmu Profile atau ProfilFinansial
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // 1. Menampilkan form HTML Register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 2. Memproses data dari form
    public function register(Request $request)
    {
        // Tahap A: Validasi Inputan
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                Password::min(6)       // Minimal 6 karakter
                    ->mixedCase()      // Wajib ada huruf besar (Kapital) & huruf kecil
                    ->symbols()        // Wajib ada simbol (@, #, $, dll)
            ],
        ], [ // <--- PERHATIKAN DI SINI: Kurung tutup array rules, koma, buka array messages
            'email.dns' => 'Gunakan email asli yang valid (contoh: @gmail.com).',
            'email.unique' => 'Email ini sudah terdaftar di FineXa.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.mixed' => 'Password harus mengandung huruf besar dan kecil.',
            'password.symbols' => 'Password harus mengandung minimal satu simbol (contoh: @, *, #).'
        ]);

        // Tahap B: Simpan User ke Database (Mapping manual agar nama_lengkap tidak error)
        $user = User::create([
            'nama_lengkap' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), 
        ]);

        // Tahap C: Buatkan Profil Kosong (Relasi 1-to-1)
        FinancialProfile::create([
            'id_user' => $user->id_user,
            // Kolom lainnya biarkan kosong/null dulu untuk diisi saat kuesioner
        ]);

        // Tahap D: Auto-Login
        // Langsung masukkan user ini ke dalam sistem tanpa perlu login manual
        Auth::login($user);
        $request->session()->regenerate();

        // Tahap E: Arahkan langsung ke halaman Kuesioner
        return redirect('/web/kuesioner')->with('success', 'Akun berhasil dibuat! Silakan isi kuesioner.');
    }
}