<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasTuaController extends Controller
{
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate(['tanggal' => 'required|date', 'nominal' => 'required|numeric']);
        \App\Models\KasTua::create($request->all());
        return back()->with('success', 'Pemasukan Kas Tua berhasil dicatat!');
    }

    public function index()
    {
        $kasTuas = \App\Models\KasTua::orderBy('tanggal', 'desc')->get();
        return view('bendahara.kastua_rincian', compact('kasTuas'));
    }
}
