<?php

namespace App\Http\Controllers;

use App\Models\FinancialProfile;
use Illuminate\Http\Request;

class FinancialProfileController extends Controller
{
    // 1. READ ALL (Hanya Baca Semua Data - Hybrid)
    public function index(Request $request) {
        $profiles = FinancialProfile::with('user')->get();
        
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $profiles]);
        }
        return view('profiles.index', compact('profiles'));
    }

    // 2. SHOW (Hanya Baca Detail 1 Data - Hybrid)
    public function show(Request $request, $id) {
        $profile = FinancialProfile::with('user')->findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $profile]);
        }
        return view('profiles.show', compact('profile'));
    }

    // 3. DESTROY (Hapus Data - Hybrid)
    // Fitur ini tetap dipertahankan jaga-jaga kalau Admin perlu 
    // mereset profil user agar user bisa isi kuesioner ulang.
    public function destroy(Request $request, $id) {
        $profile = FinancialProfile::findOrFail($id);
        $profile->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'message' => 'Profil berhasil dihapus']);
        }
        return redirect('/web/profiles')->with('success', 'Profil berhasil dihapus! User bisa mengisi kuesioner ulang.');
    }
}