<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kompensasi;

class KompensasiController extends Controller
{
    public function index()
    {
        // Ambil data dari yang terbaru
        $riwayat = Kompensasi::orderBy('tanggal', 'desc')->get();
        return view('bendahara.kompensasi', compact('riwayat'));
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'tanggal' => 'required|date',
            'sumber_dana' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
        ]);

        // Simpan ke database
        Kompensasi::create([
            'tanggal' => $request->tanggal,
            'sumber_dana' => $request->sumber_dana,
            'nominal' => $request->nominal,
        ]);

        return redirect()->back()->with('success', 'Data kompensasi berhasil ditambahkan!');
    }
}