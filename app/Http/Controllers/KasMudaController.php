<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasMudaController extends Controller
{
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate(['tanggal' => 'required|date', 'nominal' => 'required|numeric']);
        \App\Models\KasMuda::create($request->all());
        return back()->with('success', 'Pemasukan Kas Muda berhasil dicatat!');
    }
    public function index()
    {
        $kasMudas = \App\Models\KasMuda::orderBy('tanggal', 'desc')->get();
        return view('bendahara.kasmuda_rincian', compact('kasMudas'));
    }
}
