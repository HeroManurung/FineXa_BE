<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // 1. READ ALL (Minta Baca Semua Data)
    public function index(Request $request)
    {
        $faqs = Faq::all();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Data FAQ berhasil diambil',
                'data' => $faqs
            ]);
        }
        return view('faqs.index', compact('faqs'));
    }

    // 2. SHOW (Minta Baca 1 Data Spesifik)
    public function show(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $faq]);
        }
        return view('faqs.show', compact('faq'));
    }

    // 3. CREATE VIEW (Minta Kertas Formulir Kosong - Khusus Dosen/Web)
    public function create()
    {
        return view('faqs.create');
    }

    // 4. STORE (Aksi Simpan Data Baru)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori' => 'required',
            'pertanyaan' => 'required',
            'jawaban' => 'required'
        ]);

        $faq = Faq::create($validatedData);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $faq], 201);
        }
        return redirect('/web/faqs')->with('success', 'FAQ berhasil ditambahkan!');
    }

    // 5. EDIT VIEW (Minta Kertas Formulir Isi - Khusus Dosen/Web)
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('faqs.edit', compact('faq'));
    }

    // 6. UPDATE (Aksi Simpan Perubahan Data)
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori' => 'required',
            'pertanyaan' => 'required',
            'jawaban' => 'required'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($validatedData);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'data' => $faq]);
        }
        return redirect('/web/faqs')->with('success', 'FAQ berhasil diupdate!');
    }

    // 7. DESTROY (Aksi Hapus Data)
    public function destroy(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => 'success', 'message' => 'FAQ berhasil dihapus']);
        }
        return redirect('/web/faqs')->with('success', 'FAQ berhasil dihapus!');
    }
}