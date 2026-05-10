<?php

namespace App\Http\Controllers;

use App\Models\FinancialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuesionerController extends Controller
{
    // 1. Menampilkan halaman form (Hybrid)
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'message' => 'Silakan tampilkan form kuesioner di React']);
        }
        return view('kuesioner');
    }

    // 2. Memproses data (Hybrid & Smart)
    public function simpan(Request $request)
    {
        // Tahap A: Validasi Inputan
        $request->validate([
            'skor_waktu' => 'required|integer|between:1,3',
            'skor_risiko' => 'required|integer|between:1,3',
            'skor_kapasitas' => 'required|integer|between:1,3',
            'skor_hutang' => 'required|integer|between:1,3',
            'skor_pengetahuan' => 'required|integer|between:1,3',
            'profil_risiko' => 'required|string', 
        ]);

        // Tahap B: Mesin Kalkulator Total Poin
        $totalPoin = $request->skor_waktu + $request->skor_risiko + $request->skor_kapasitas + $request->skor_hutang + $request->skor_pengetahuan;

        // Tahap C: Algoritma CDW (Indeks Risiko 0-100)
        $riskIndex = (($totalPoin - 5) / 10) * 100;

        // Tahap D: Hitung Persentase Aset
        $persenSaham = $riskIndex * 0.6; 
        $persenPasarUang = (100 - $riskIndex) * 0.7; 
        
        $sisa = 100 - ($persenSaham + $persenPasarUang);
        $persenObligasi = $sisa * 0.6;
        $persenCampuran = $sisa * 0.4;

        // Tahap E: Simpan atau Perbarui (Jurus updateOrCreate)
        $user = Auth::user(); 
        
        $profile = FinancialProfile::updateOrCreate(
            ['id_user' => $user->id_user], // Cari berdasarkan ID User
            [
                'skor_waktu' => $request->skor_waktu,
                'skor_risiko' => $request->skor_risiko,
                'skor_kapasitas' => $request->skor_kapasitas,
                'skor_hutang' => $request->skor_hutang,
                'skor_pengetahuan' => $request->skor_pengetahuan,
                'total_poin' => $totalPoin,
                'profil_risiko' => $request->profil_risiko,
                'persen_saham' => $persenSaham,
                'persen_pasar_uang' => $persenPasarUang,
                'persen_obligasi' => $persenObligasi,
                'persen_campuran' => $persenCampuran,
            ]
        );

        // Tahap F: Respon Hybrid
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Analisis berhasil dihitung!',
                'data' => $profile
            ]);
        }

        return redirect('/web/analisis')->with('success', 'Kuesioner berhasil disimpan!');
    }
}