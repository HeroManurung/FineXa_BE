<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        // Si Remote Control (Model) mengambil semua data dari database
        $faqs = Faq::all();

        // 1. JALUR API: Jika yang meminta adalah aplikasi ReactJS dari tim frontend
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Data FAQ berhasil diambil',
                'data' => $faqs
            ]);
        }

        // 2. JALUR WEB: Jika yang meminta adalah Admin lewat browser
        return view('faqs.index', compact('faqs'));
    }
}