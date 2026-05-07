<?php

namespace App\Http\Controllers;

use App\Models\FinancialProfile;
use App\Models\User;
use Illuminate\Http\Request;

class FinancialProfileController extends Controller
{
    public function index(Request $request) {
        $profiles = FinancialProfile::with('user')->get();
        if ($request->wantsJson()) return response()->json(['status' => 'success', 'data' => $profiles]);
        return view('profiles.index', compact('profiles'));
    }

    public function edit($id) {
        $profile = FinancialProfile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'sumber_pendapatan' => 'required',
            'nominal_pendapatan' => 'required|numeric',
            'persentase_tabungan' => 'required|numeric',
            'perilaku_belanja' => 'required',
            'tipe_investor' => 'required'
        ]);

        $profile = FinancialProfile::findOrFail($id);
        $profile->update($validated);

        if ($request->wantsJson()) return response()->json(['status' => 'success', 'data' => $profile]);
        return redirect('/web/profiles')->with('success', 'Data kuesioner berhasil diperbarui!');
    }
}