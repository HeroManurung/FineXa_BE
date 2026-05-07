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
        if ($request->wantsJson()) return response()->json(['status' => 'success', 'data' => $users]);
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
            if ($request->wantsJson()) return response()->json(['status' => 'success', 'data' => $user], 201);
            return redirect('/web/users')->with('success', 'User dan Profil berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mendaftar.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // PENTING: Kita harus menghapus "Map" profilnya dulu, 
            // agar tidak jadi data yatim piatu di database.
            if ($user->profile) {
                $user->profile->delete();
            }

            // Setelah profilnya terhapus, baru kita hapus akun usernya
            $user->delete();

            return redirect('/web/users')->with('success', 'User dan seluruh data kuesionernya berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}