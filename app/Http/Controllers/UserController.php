<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $users]);
        }
        return view('users.index', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'investor'
            ]);

            FinancialProfile::create([
                'id_user' => $user->id_user
            ]);

            DB::commit();

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => 'success', 'data' => $user], 201);
            }
            return redirect('/web/users')->with('success', 'User dan Profil berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal mendaftar.');
        }
    }

    // --- TAMBAHKAN FUNGSI SHOW UNTUK API ---
    public function show(Request $request, $id) {
        $user = User::findOrFail($id);
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $user]);
        }
        return view('users.show', compact('user'));
    }

    // --- TAMBAHKAN FUNGSI UPDATE UNTUK API ---
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users,email,'.$id.',id_user',
        ]);

        $user->update($request->all());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'message' => 'User diperbarui', 'data' => $user]);
        }
        return redirect('/web/users')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Cek relasi (sesuaikan nama di model User, biasanya financialProfile)
            if ($user->financialProfile) {
                $user->financialProfile->delete();
            }

            $user->delete();

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => 'success', 'message' => 'User berhasil dihapus']);
            }
            return redirect('/web/users')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus user.');
        }
    }
}