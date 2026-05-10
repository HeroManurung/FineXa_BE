<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    // Ingat, tambahkan (Request $request) di dalam tanda kurung ini!
    public function index(Request $request)
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();
        
        // 2. Ambil data profil keuangannya
        $profile = $user->financialProfile;

        // 3. Cek apakah dia sudah punya 'profil_risiko'
        if (!$profile || $profile->profil_risiko == null) {
            
            // --- JALUR API (Untuk ReactJS Rian) ---
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'warning',
                    'pesan' => 'Silakan isi kuesioner terlebih dahulu.',
                    'action' => 'redirect_kuesioner' // Sinyal agar React memindahkan layar
                ], 403); // 403 artinya akses ditahan sementara
            }

            // --- JALUR WEB ---
            return redirect('/web/kuesioner')->with('info', 'Silakan isi kuesioner terlebih dahulu untuk mendapatkan hasil analisis investasi Anda.');
        }

        // 4. Jika sudah pernah isi kuesioner, tampilkan datanya
        
        // --- JALUR API ---
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => $user,
                    'profile' => $profile
                ]
            ]);
        }

        // --- JALUR WEB ---
        return view('analisis.index', compact('user', 'profile'));
    }
}