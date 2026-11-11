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
        $brankas = \App\Models\KasOrganisasi::find(1);
        $brankas->saldo_dansos -= $request->nominal; // Kurangi saldo sesuai yang dikeluarkan
        $brankas->save();
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
        // 1. Mengambil data Pengeluaran & Talangan
        $pengeluaran = \App\Models\PengeluaranDansos::latest()->get();
        $talangan = \App\Models\TalanganDansos::latest()->get();

        // 2. MENGHITUNG KEUANGAN (Samakan dengan logika Dashboard menggunakan kolom 'tanggal')
        $bulanIni = \Carbon\Carbon::now()->format('Y-m');

        // Total bulan kemarin (akumulasi semua dansos & arisan sebelum bulan ini)
        $totalBulanKemarin = \App\Models\Iuran::whereRaw("DATE_FORMAT(tanggal, '%Y-%m') < ?", [$bulanIni])
            ->sum(\Illuminate\Support\Facades\DB::raw('dansos + arisan'));

        // Setoran masuk untuk bulan ini
        $setoranBulanIni = \App\Models\Iuran::whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->sum('dansos');

        // === MENGAMBIL SALDO DARI BRANKAS PERMANEN ===
        $brankas = \App\Models\KasOrganisasi::first();
        $totalSaldoDansos = $brankas ? $brankas->saldo_dansos : 0;

        // 3. Mengirim SEMUA variabel ke halaman View Laporan Publik
        return view('dansos.laporan', compact(
            'pengeluaran',
            'talangan',
            'totalBulanKemarin',
            'setoranBulanIni',
            'totalSaldoDansos'
        ));
    }
}