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

    public function laporanPublik()
    {
        // 1. Mengambil data Pengeluaran & Talangan (sudah ada sebelumnya)
        $pengeluaran = \App\Models\PengeluaranDansos::latest()->get();
        $talangan = \App\Models\TalanganDansos::latest()->get();

        // 2. Menghitung Total Bulan Kemarin & Bulan Ini (TAMBAHAN BARU)
        // Menggunakan Carbon untuk mendapatkan bulan dan tahun
        $bulanKemarin = \Carbon\Carbon::now()->subMonth()->month;
        $tahunKemarin = \Carbon\Carbon::now()->subMonth()->year;
        $bulanIni = \Carbon\Carbon::now()->month;
        $tahunIni = \Carbon\Carbon::now()->year;

        // Contoh Query (Asumsi nama modelnya Iuran dan menggunakan kolom created_at)
        // Silakan sesuaikan 'Iuran', 'dansos', dan 'arisan' dengan nama tabel/model Mas Doni yang sebenarnya
        $totalBulanKemarin = \App\Models\Iuran::whereMonth('created_at', $bulanKemarin)
                                              ->whereYear('created_at', $tahunKemarin)
                                              ->sum('dansos') 
                           + \App\Models\Iuran::whereMonth('created_at', $bulanKemarin)
                                              ->whereYear('created_at', $tahunKemarin)
                                              ->sum('arisan');

        $setoranBulanIni = \App\Models\Iuran::whereMonth('created_at', $bulanIni)
                                            ->whereYear('created_at', $tahunIni)
                                            ->sum('dansos');

        // 3. Mengirim SEMUA variabel ke halaman View
        return view('dansos.laporan', compact(
            'pengeluaran', 
            'talangan', 
            'totalBulanKemarin', 
            'setoranBulanIni'
        ));
    }
}