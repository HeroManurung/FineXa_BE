<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib dipanggil untuk fitur Login

class LoginController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman form HTML
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Fungsi untuk memproses data saat tombol "Masuk" diklik
    public function authenticate(Request $request)
    {
        // Tahap A: Validasi - Pastikan user mengisi email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah user mencentang checkbox "Ingat saya" di form login
        $remember = $request->has('remember');

        // Tahap B: Mesin Pengecek (Mencocokkan Kunci ke Database)
        if (Auth::attempt($credentials, $remember)) {
            
        // Tahap C: Jika sukses, buatkan "Kartu Akses" (Session) baru agar aman dari hacker
            $request->session()->regenerate();
            
        // Tahap D: BACA ROLE USER UNTUK MEMBEDAKAN ARAH REDIRECT
            $userRole = Auth::user()->role; // Ini cara backend tahu jabatannya!

        if ($userRole === 'admin') {
            // Jika Admin, persilakan masuk ke ruang kontrol (data users)
            return redirect()->intended('/web/users');
        } elseif ($userRole === 'investor') {
            // Jika Investor, arahkan ke halaman mereka sendiri (misal: kuesioner)
            return redirect()->intended('/web/analisis');
        }
        }

        // Tahap E: Jika gagal (email/password salah), tendang balik ke halaman form
        return back()->withErrors([
            'email' => 'Maaf, Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email'); // Biar email yang tadi diketik nggak hilang
    }
    
    // 3. Fungsi untuk Logout (Keluar Sistem)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}