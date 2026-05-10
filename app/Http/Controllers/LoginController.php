<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. TAMPILAN WEB
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. PROSES LOGIN (HYBRID: WEB & API)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // Jika Email & Password Cocok!
        if (Auth::attempt($credentials, $remember)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $userRole = $user->role;

            // --- JALUR API (Untuk ReactJS Rian) ---
            if ($request->wantsJson() || $request->is('api/*')) {
                // Buatkan Kartu VIP (Token Sanctum)
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'pesan' => 'Login berhasil',
                    'role' => $userRole,
                    'token' => $token, // INI YANG PALING DIBUTUHKAN REACTJS!
                    'data' => $user
                ]);
            }

            // --- JALUR WEB (Untuk Presentasi Dosen) ---
            $request->session()->regenerate();

            if ($userRole === 'admin') {
                return redirect()->intended('/web/users');
            } elseif ($userRole === 'investor') {
                return redirect()->intended('/web/analisis');
            }
        }

        // Jika Email/Password Salah!
        // --- JALUR API ---
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'pesan' => 'Email atau Password salah'
            ], 401); // 401 = Unauthorized
        }

        // --- JALUR WEB ---
        return back()->withErrors([
            'email' => 'Maaf, Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
    
    // 3. PROSES LOGOUT (HYBRID: WEB & API)
    public function logout(Request $request)
    {
        // --- JALUR API ---
        if ($request->wantsJson() || $request->is('api/*')) {
            // Hancurkan Kartu VIP (Token) milik user yang sedang login
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'status' => 'success',
                'pesan' => 'Berhasil logout dan token dihapus'
            ]);
        }

        // --- JALUR WEB ---
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}