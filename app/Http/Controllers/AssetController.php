<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // READ ALL
    public function index(Request $request) {
        $assets = Asset::all();
        if ($request->wantsJson()) return response()->json(['status' => 'success', 'data' => $assets]);
        return view('assets.index', compact('assets'));
    }

    // SHOW (Baca 1 Data Spesifik)
    public function show(Request $request, $id) {
        $asset = Asset::findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'data' => $asset
            ]);
        }
        return view('assets.show', compact('asset')); 
    }

    // CREATE VIEW (Hanya untuk Web/Dosen)
    public function create() {
        return view('assets.create');
    }

    // STORE (Proses Simpan)
    public function store(Request $request) {
        // 1. Simpan hasil validasi ke dalam variabel $validatedData
        $validatedData = $request->validate([
            'nama_aset' => 'required',
            'kategori_aset' => 'required',
            'tingkat_risiko' => 'required'
        ]);

        // 2. Gunakan variabel tersebut untuk create (otomatis tanpa _token)
        $asset = Asset::create($validatedData);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $asset], 201);
        }
        return redirect('/web/assets')->with('success', 'Aset berhasil ditambahkan!');
    }

    // EDIT VIEW (Hanya untuk Web/Dosen)
    public function edit($id) {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    // UPDATE (Proses Ubah)
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'nama_aset' => 'required',
            'kategori_aset' => 'required',
            'tingkat_risiko' => 'required'
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update($validatedData);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $asset]);
        }
        return redirect('/web/assets')->with('success', 'Aset berhasil diupdate!');
    }

    // DESTROY (Proses Hapus)
    public function destroy(Request $request, $id) {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Aset dihapus']);
        }
        return redirect('/web/assets')->with('success', 'Aset berhasil dihapus!');
    }
}