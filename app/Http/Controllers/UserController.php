<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request) {
        // 🚨 JURUS JOIN (Versi Nama Kolom yang Benar) 🚨
        $users = DB::table('users')
            ->leftJoin('financial_profiles', 'users.id_user', '=', 'financial_profiles.id_user')
            ->select(
                'users.id_user', 
                'users.nama_lengkap', 
                'users.email', 
                'users.role', 
                'users.created_at', 
                'users.last_login_at',
                'financial_profiles.profil_risiko' // 👈 Ini udah diganti pakai bahasa Indonesia!
            )
            ->orderBy('users.created_at', 'desc')
            ->get();

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

    // --- FUNGSI UPDATE YANG SUDAH DIPERBAIKI ---
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        // 1. Validasi Input
        $request->validate([
            'nama_lengkap' => 'required',
            'password' => [
                'nullable', // Boleh dikosongkan kalau cuma mau ganti nama
                Password::min(6)       // Minimal 6 karakter
                    ->mixedCase()      // Wajib huruf besar & kecil
                    ->symbols()        // Wajib ada simbol
            ]
        ], [
            // Pesan Error Bahasa Indonesia (Muncul kalau aturannya dilanggar)
            'password.min' => 'Password baru minimal harus 6 karakter.',
            'password.mixed' => 'Password baru harus mengandung huruf besar dan kecil.',
            'password.symbols' => 'Password baru harus mengandung minimal satu simbol (contoh: @, *, #).'
        ]);

        // 2. Siapkan data yang aman untuk di-update
        $dataUpdate = [
            'nama_lengkap' => $request->nama_lengkap,
        ];

        // 3. Cek apakah user mengisi password baru? Kalau iya, Enkripsi!
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        // 4. Eksekusi Update
        $user->update($dataUpdate);

        // 5. Kembalikan Respon
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success', 
                'message' => 'Profil berhasil diperbarui!', 
                'data' => $user
            ]);
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