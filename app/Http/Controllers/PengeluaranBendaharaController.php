<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBendahara;

class PengeluaranBendaharaController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi inputan
        $request->validate([
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keperluan' => 'required|string|max:255',
        ]);

        // 2. Simpan ke database
        PengeluaranBendahara::create($request->all());

        // 3. Kembalikan ke halaman sebelumnya
        return back()->with('success', 'Data pengeluaran bendahara berhasil dicatat!');
    }

    public function index()
    {
        // Ambil semua data pengeluaran dari yang terbaru
        $pengeluarans = PengeluaranBendahara::orderBy('tanggal', 'desc')->get();
        
        return view('bendahara.pengeluaran_rincian', compact('pengeluarans'));
    }
}
