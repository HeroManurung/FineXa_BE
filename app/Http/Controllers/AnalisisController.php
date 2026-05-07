<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();
        
        // 2. Ambil data profil keuangannya (SESUAIKAN DENGAN NAMA FUNCTION DI USER.PHP)
        $profile = $user->financialProfile; // <--- Ini perubahannya!

        // 3. LOGIKA PINTAR: Cek apakah dia sudah punya 'profil_risiko'
        // Kalau masih kosong (null), berarti dia belum isi kuesioner! Lempar ke kuesioner.
        if (!$profile || $profile->profil_risiko == null) {
            return redirect('/web/kuesioner')->with('info', 'Silakan isi kuesioner terlebih dahulu untuk mendapatkan hasil analisis investasi Anda.');
        }

        // 4. Jika sudah pernah isi kuesioner, tampilkan halamannya
        return view('analisis.index', compact('user', 'profile'));
    }
}