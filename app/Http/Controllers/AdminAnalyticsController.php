<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FaqLog;
use App\Models\LoginLog; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // 1. HITUNG TOTAL VIEWS (Dari faq_logs)
        $totalViews = FaqLog::count();
        
        // 2. REVISI DOSEN: HITUNG TOTAL LOGIN (Tanpa batasan distinct)
        $activeUsers = LoginLog::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // 3. HITUNG RATA-RATA ENGAGEMENT DARI TABEL
        // Ambil semua FAQ yang pernah di-klik, hitung persentasenya
        $allContentEngagement = DB::table('faq_logs')
            ->select('faq_id', DB::raw('COUNT(id) as views'))
            ->groupBy('faq_id')
            ->get()
            ->map(function ($item) use ($totalViews) {
                return $totalViews > 0 ? round(($item->views / $totalViews) * 100, 1) : 0;
            });

        // Hitung rata-rata murni dari kumpulan persentase di atas
        $avgEngagement = $allContentEngagement->count() > 0 
            ? round($allContentEngagement->avg(), 1) 
            : 0;

        // 4. AMBIL TOP 5 KONTEN UNTUK TABEL BAWAH
        $topContent = DB::table('faq_logs')
            ->join('faqs', 'faq_logs.faq_id', '=', 'faqs.id_faq')
            ->select('faqs.pertanyaan as title', DB::raw('COUNT(faq_logs.id) as views'))
            ->groupBy('faqs.id_faq', 'faqs.pertanyaan')
            ->orderByDesc('views')
            ->limit(5) 
            ->get()
            ->map(function ($item) use ($totalViews) {
                $engagement = $totalViews > 0 ? round(($item->views / $totalViews) * 100, 1) : 0;
                return [
                    'title' => $item->title,
                    'views' => $item->views,
                    'engagement' => $engagement
                ];
            });

        // 5. HITUNG PERTUMBUHAN MINGGUAN (GROWTH)
        // a. Pertumbuhan Views
        $viewsMingguIni = FaqLog::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $viewsMingguLalu = FaqLog::whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()->subDays(7)])->count();
        
        $viewsGrowth = 0;
        if ($viewsMingguLalu > 0) {
            $viewsGrowth = round((($viewsMingguIni - $viewsMingguLalu) / $viewsMingguLalu) * 100, 1);
        } else if ($viewsMingguIni > 0) {
            $viewsGrowth = 100; 
        }

        // b. Pertumbuhan Users/Login (Revisi: Tanpa distinct)
        $usersMingguIni = $activeUsers; 
        $usersMingguLalu = LoginLog::whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()->subDays(7)])->count();
        
        $usersGrowth = 0;
        if ($usersMingguLalu > 0) {
            $usersGrowth = round((($usersMingguIni - $usersMingguLalu) / $usersMingguLalu) * 100, 1);
        } else if ($usersMingguIni > 0) {
            $usersGrowth = 100;
        }

        // Pertumbuhan engagement kita selaraskan dengan views
        $engagementGrowth = $viewsGrowth; 

        // 6. BUNGKUS DAN KIRIM KE REACT
        return response()->json([
            'status' => 'success',
            'data' => [
                'stats' => [
                    'total_views' => $totalViews,
                    'active_users' => $activeUsers,
                    'avg_engagement' => $avgEngagement,
                    'views_growth' => $viewsGrowth,
                    'users_growth' => $usersGrowth,
                    'engagement_growth' => $engagementGrowth
                ],
                'top_content' => $topContent
            ]
        ]);
    }
}