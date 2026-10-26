<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;

class ArisanController extends Controller
{
    public function index()
    {
        // 1. MENGAMBIL DATA DARI HUMAS (Contoh query dinamis)
        // Catatan: Sesuaikan 'rt' dengan struktur database Mas Doni. 
        // Sementara kita pakai nilai bawaan (fallback) agar tampilan langsung jalan.
        $arisanCandi = Iuran::whereHas('anggota', function($q) {
            $q->where('rt', '23');
        })->whereMonth('tanggal', date('m'))->sum('arisan') ?: 110000; 

        $arisanGunung = Iuran::whereHas('anggota', function($q) {
            $q->where('rt', '24');
        })->whereMonth('tanggal', date('m'))->sum('arisan') ?: 185000;

        $totalHumas = $arisanCandi + $arisanGunung; // Rp 295.000

        // 2. PEMOTONGAN WAJIB DANSOS
        $potonganDansos = 25000;
        $sisaSetelahDansos = $totalHumas - $potonganDansos; // Rp 270.000

        // 3. LOGIKA DEFISIT / GALI LUBANG TUTUP LUBANG
        // Nilai ini nantinya diambil dari tabel riwayat_arisan bulan sebelumnya
        $kekuranganBulanKemarin = 80000; 
        
        // Bersih yang didapat tuan rumah malam ini
        $arisanMendapatkan = $sisaSetelahDansos - $kekuranganBulanKemarin; // Rp 190.000

        // Menghitung defisit baru (misal target hak tuan rumah adalah Rp 285.000)
        $targetHakTuanRumah = 285000; 
        $masihKurangBulanIni = $targetHakTuanRumah - $arisanMendapatkan; // Rp 100.000
        $daftarAnggota = \App\Models\Anggota::pluck('nama');

        return view('arisan.dashboard', compact(
            'arisanCandi', 
            'arisanGunung', 
            'totalHumas', 
            'potonganDansos', 
            'sisaSetelahDansos',
            'kekuranganBulanKemarin',
            'arisanMendapatkan',
            'masihKurangBulanIni',
            'daftarAnggota'
        ));
    }

    public function simpanLaporan(\Illuminate\Http\Request $request)
    {
        // 1. Validasi inputan petugas
        $request->validate([
            'tempat' => 'required|string',
            'target_hak' => 'required|numeric|min:0'
        ]);

        // 2. Hitung ulang di background (Server-side) agar aman
        $arisanCandi = \App\Models\Iuran::where('status_riwayat', 'aktif')->whereHas('anggota', function($q) { $q->where('rt', '23'); })->sum('arisan');
        $arisanGunung = \App\Models\Iuran::where('status_riwayat', 'aktif')->whereHas('anggota', function($q) { $q->where('rt', '24'); })->sum('arisan');
        
        $totalHumas = $arisanCandi + $arisanGunung;
        $potonganDansos = 25000;
        $sisaSetelahDansos = $totalHumas - $potonganDansos;
        
        $riwayatBulanLalu = \App\Models\RiwayatArisan::where('status', 'selesai')->orderBy('tanggal', 'desc')->first();
        $kekuranganBulanKemarin = $riwayatBulanLalu ? $riwayatBulanLalu->masih_kurang : 0;
        
        $arisanMendapatkan = $sisaSetelahDansos - $kekuranganBulanKemarin;
        
        $targetHak = $request->target_hak;
        $masihKurang = max(0, $targetHak - $arisanMendapatkan);

        // 3. Masukkan ke database Riwayat Arisan
        \App\Models\RiwayatArisan::create([
            'tanggal' => \Carbon\Carbon::now(),
            'tempat' => $request->tempat,
            'pemasukan_candi' => $arisanCandi,
            'pemasukan_gunung' => $arisanGunung,
            'total_kas_awal' => $totalHumas,
            'potongan_dansos' => $potonganDansos,
            'tutup_defisit_lalu' => $kekuranganBulanKemarin,
            'arisan_mendapatkan' => $arisanMendapatkan,
            'target_hak_tuan_rumah' => $targetHak,
            'masih_kurang' => $masihKurang,
            'status' => 'selesai'
        ]);

        // 4. Kunci setoran Humas bulan ini (ubah 'aktif' menjadi 'selesai')
        \App\Models\Iuran::where('status_riwayat', 'aktif')->update(['status_riwayat' => 'selesai']);

        return redirect()->back()->with('success', 'Laporan Arisan bulan ini berhasil dikunci & disimpan!');
    }

    public function riwayat()
    {
        // Mengambil semua data riwayat dari yang paling baru ke yang paling lama
        $riwayats = \App\Models\RiwayatArisan::orderBy('tanggal', 'desc')->get();
        return view('arisan.riwayat', compact('riwayats'));
    }

    public function laporanPublik()
    {
        // 1. Ambil Data
        $arisanCandi = \App\Models\Iuran::where('status_riwayat', 'aktif')->whereHas('anggota', function($q){ $q->where('rt', '23'); })->sum('arisan');
        $arisanGunung = \App\Models\Iuran::where('status_riwayat', 'aktif')->whereHas('anggota', function($q){ $q->where('rt', '24'); })->sum('arisan');
        $totalHumas = $arisanCandi + $arisanGunung;

        // 2. Cek riwayat lalu & hitung
        $riwayatBulanLalu = \App\Models\RiwayatArisan::where('status', 'selesai')->orderBy('tanggal', 'desc')->first();
        $kekuranganBulanKemarin = $riwayatBulanLalu ? $riwayatBulanLalu->masih_kurang : 0;
        $targetHakTuanRumah = 285000;

        if ($totalHumas == 0) {
            $potonganDansos = 0; $sisaSetelahDansos = 0; $arisanMendapatkan = 0; $masihKurangBulanIni = 0;
        } else {
            $potonganDansos = 25000;
            $sisaSetelahDansos = $totalHumas - $potonganDansos;
            $arisanMendapatkan = $sisaSetelahDansos - $kekuranganBulanKemarin;
            $masihKurangBulanIni = max(0, $targetHakTuanRumah - $arisanMendapatkan);
        }

        return view('arisan.laporan_publik', compact('totalHumas', 'potonganDansos', 'sisaSetelahDansos', 'kekuranganBulanKemarin', 'arisanMendapatkan', 'masihKurangBulanIni', 'targetHakTuanRumah'));
    }
}
