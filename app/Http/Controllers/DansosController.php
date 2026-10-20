<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranDansos;
use App\Models\TalanganDansos;

class DansosController extends Controller
{
    public function index()
    {
        $pengeluarans = PengeluaranDansos::orderBy('tanggal', 'desc')->get();
        return view('dansos.pengeluaran', compact('pengeluarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Sakit,Takziah',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ]);

        PengeluaranDansos::create($request->all());

        return back()->with('success', 'Catatan pengeluaran berhasil disimpan!');
    }

    public function destroy($id)
    {
        PengeluaranDansos::findOrFail($id)->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    public function talanganIndex()
    {
        $talangans = TalanganDansos::orderBy('tanggal', 'desc')->get();
        return view('dansos.talangan', compact('talangans'));
    }

    public function talanganStore(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ]);

        TalanganDansos::create($request->all());

        return back()->with('success', 'Dana talangan berhasil dicatat!');
    }

    public function talanganDestroy($id)
    {
        TalanganDansos::findOrFail($id)->delete();
        return back()->with('success', 'Data talangan berhasil dihapus!');
    }
}