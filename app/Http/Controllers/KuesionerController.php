<?php

namespace App\Http\Controllers;

use App\Models\FinancialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuesionerController extends Controller
{
    // 1. Menampilkan halaman form kuesioner
    public function index()
    {
        return view('kuesioner');
    }

    // 2. Memproses data dari form, menghitung, dan menyimpan ke database
    public function simpan(Request $request)
    {
        // Tahap A: Validasi Inputan
        $request->validate([
            'skor_waktu' => 'required|integer|between:1,3',
            'skor_risiko' => 'required|integer|between:1,3',
            'skor_kapasitas' => 'required|integer|between:1,3',
            'skor_hutang' => 'required|integer|between:1,3',
            'skor_pengetahuan' => 'required|integer|between:1,3',
            'profil_risiko' => 'required|string', // Penting: User memilih sendiri profilnya
        ]);

        // Tahap B: Mesin Kalkulator Total Poin
        $totalPoin = $request->skor_waktu + $request->skor_risiko + $request->skor_kapasitas + $request->skor_hutang + $request->skor_pengetahuan;

        // Tahap C: Algoritma Continuous Dynamic Weighting (Indeks Risiko 0-100)
        $riskIndex = (($totalPoin - 5) / 10) * 100;

        // Tahap D: Hitung Persentase Aset (Desimal Dinamis)
        $persenSaham = $riskIndex * 0.6; // Maksimal 60%
        $persenPasarUang = (100 - $riskIndex) * 0.7; // Maksimal 70%
        
        $sisa = 100 - ($persenSaham + $persenPasarUang);
        $persenObligasi = $sisa * 0.6;
        $persenCampuran = $sisa * 0.4;

        // Tahap E: Simpan Data ke Profil Kosong Milik User
        $user = Auth::user(); 
        
        FinancialProfile::where('id_user', $user->id_user)->update([
            'skor_waktu' => $request->skor_waktu,
            'skor_risiko' => $request->skor_risiko,
            'skor_kapasitas' => $request->skor_kapasitas,
            'skor_hutang' => $request->skor_hutang,
            'skor_pengetahuan' => $request->skor_pengetahuan,
            'total_poin' => $totalPoin,
            'profil_risiko' => $request->profil_risiko, // Sesuai pilihan user dari 6 profil
            'persen_saham' => $persenSaham,
            'persen_pasar_uang' => $persenPasarUang,
            'persen_obligasi' => $persenObligasi,
            'persen_campuran' => $persenCampuran,
        ]);

        // Tahap F: Arahkan ke halaman hasil (Dashboard/Analisis)
        return redirect('/web/analisis');
    }
}