<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. HITUNG 3 KARTU STATISTIK UTAMA (Seperti Awal)
        $totalUsers = User::count();
        $totalFaq = faq::count();
        
        // IDE BOS HERO: Menghitung MAU (Monthly Active Users) alias akun unik yang login bulan ini
        $activeSessions = User::where('last_login_at', '>=', now()->subDays(30))->count(); 

        // 2. HITUNG PERTUMBUHAN DINAMIS (HANYA UNTUK KARTU ACTIVE SESSIONS)
        $activeBulanIni = $activeSessions;
        $activeBulanLalu = User::whereBetween('last_login_at', [now()->subDays(60), now()->subDays(30)])->count();
        $activeGrowth = $activeBulanLalu > 0 ? round((($activeBulanIni - $activeBulanLalu) / $activeBulanLalu) * 100, 1) : ($activeBulanIni > 0 ? 100 : 0);

        // 3. Hitung Data Grafik Garis (Pertumbuhan Pengguna per Bulan)
        $chartPertumbuhan = User::select(
                DB::raw("DATE_FORMAT(created_at, '%b') as name"),
                DB::raw("COUNT(*) as pengguna")
            )
            ->groupBy('name')
            ->orderByRaw("MIN(created_at)") 
            ->get();

        // 4. Hitung Data Grafik Lingkaran (Distribusi Profil Risiko)
        $chartRisiko = DB::table('financial_profiles')
            ->select(
                'profil_risiko as name', 
                DB::raw('COUNT(*) as value')
            )
            ->whereNotNull('profil_risiko')       
            ->where('profil_risiko', '!=', '')
            ->groupBy('profil_risiko')
            ->get();

        // 5. Bungkus semua datanya dan kirim ke React!
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_users' => $totalUsers,
                'total_faq' => $totalFaq,
                'active_sessions' => $activeSessions,
                'active_growth' => $activeGrowth,   // Hanya ini yang dikirim dinamis untuk persentase
                'chart_pertumbuhan' => $chartPertumbuhan,
                'chart_risiko' => $chartRisiko            
            ]
        ]);
    }
}