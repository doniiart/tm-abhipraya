<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Iuran;
use Carbon\Carbon;

class HumasController extends Controller
{
    public function index()
    {
        // Ambil data anggota berdasarkan RT
       $anggotaRT23 = \App\Models\Anggota::where('rt', '23')->get();
        $anggotaRT24 = \App\Models\Anggota::where('rt', '24')->get();

        // 1. Ambil data agenda
        $agendas = \App\Models\MeetingAgenda::orderBy('tanggal', 'desc')->get();

        // --- HITUNG KEUANGAN DANSOS ---
        // Pemasukan Bulan Ini (Misal: Bulan Oktober 2026 atau bulan berjalan)
        $bulanIni = \Carbon\Carbon::now()->format('Y-m');
        
        // Total dansos bulan ini dari semua setoran
        $pemasukanBulanIni = \App\Models\Iuran::whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->sum('dansos');

        // Total bulan kemarin (akumulasi sebelum bulan ini)
        $pemasukanBulanKemarin = \App\Models\Iuran::whereRaw("DATE_FORMAT(tanggal, '%Y-%m') < ?", [$bulanIni])
            ->sum(DB::raw('dansos + arisan')); // Sesuai permintaan: total dansos + arisan bulan kemarin

        // Pengeluaran (Contoh statis atau bisa diambil dari tabel pengeluaran jika sudah ada)
        $pengeluaranSakitTakziah = 100000; 
        $talanganTabungan = 0;

        // Total Saldo Dansos Tersisa
        // Rumus: (Bulan Kemarin + Pemasukan Bulan Ini) - Pengeluaran + Talangan
        $totalSaldoDansos = ($pemasukanBulanKemarin + $pemasukanBulanIni) - $pengeluaranSakitTakziah + $talanganTabungan;

        $agendaSebelumnya = \App\Models\MeetingAgenda::where('status', 'selesai')
                                ->orderBy('id', 'desc')
                                ->first();

       // 1. Ambil 2 Agenda Terakhir yang diurutkan berdasarkan ID terbaru
        // (Agenda index [0] adalah agenda bulan ini yang sedang berjalan)
        // (Agenda index [1] adalah agenda bulan KEMARIN yang sudah lewat)
        $duaAgendaTerakhir = \App\Models\MeetingAgenda::orderBy('id', 'desc')->take(2)->get();
        
        // 2. Pastikan minimal ada 2 agenda di sistem, baru kita bisa ngecek "bulan kemarin"
        if ($duaAgendaTerakhir->count() > 1) {
            $agendaKemarin = $duaAgendaTerakhir[1]; // Ambil data agenda bulan lalu
            $tanggalKemarin = $agendaKemarin->tanggal; // Asumsi kolomnya bernama 'tanggal' di tabel meeting_agendas

            // 3. Cek tunggakan untuk anggota RT 23
            foreach ($anggotaRT23 as $anggota) {
                // Cek apakah anggota ini ADA menyetor uang di "tanggalKemarin"
                $cekIuran = \App\Models\Iuran::where('anggota_id', $anggota->id)
                                             ->where('tanggal', $tanggalKemarin)
                                             ->first();

                // Jika datanya tidak ada, atau total arisan+tabungan+dansos = 0, berarti nunggak!
                if (!$cekIuran || ($cekIuran->arisan + $cekIuran->tabungan + $cekIuran->dansos) == 0) {
                    $anggota->punya_tunggakan = true;
                } else {
                    $anggota->punya_tunggakan = false;
                }
            }

            // 4. Lakukan hal yang sama untuk anggota RT 24
            foreach ($anggotaRT24 as $anggota) {
                $cekIuran = \App\Models\Iuran::where('anggota_id', $anggota->id)
                                             ->where('tanggal', $tanggalKemarin)
                                             ->first();

                if (!$cekIuran || ($cekIuran->arisan + $cekIuran->tabungan + $cekIuran->dansos) == 0) {
                    $anggota->punya_tunggakan = true;
                } else {
                    $anggota->punya_tunggakan = false;
                }
            }
        }
        // -----------------------------

        // 2. TAMBAHKAN VARIABEL KEUANGAN KE DALAM COMPACT
        return view('dashboard', compact(
            'anggotaRT23', 
            'anggotaRT24', 
            'agendas', 
            'pemasukanBulanKemarin', 
            'pemasukanBulanIni', 
            'pengeluaranSakitTakziah', 
            'talanganTabungan', 
            'totalSaldoDansos'
        ));
    }

    public function storeIuran(Request $request)
    {
        $anggotaIds = $request->input('anggota_ids', []);
        $kelipatanInput = $request->input('kelipatan', []);

        if (empty($anggotaIds)) {
            return back()->with('error', 'Belum ada anggota yang dicentang untuk asok iuran.');
        }

        // 1. AMBIL JADWAL DARI TABEL SETTING_WEBS (Sesuai kolom asli database)
        $setting = \App\Models\SettingWeb::first();
        
        // Ambil lokasi dari kolom agenda_lokasi
        $tempatDipilih = $setting ? $setting->agenda_lokasi : 'Tempat Sesuai Agenda';
        
        // Ambil tanggal dari agenda_target_countdown (tipe datetime), atau fallback ke hari ini
        if ($setting && !empty($setting->agenda_target_countdown)) {
            $tanggalDipilih = \Carbon\Carbon::parse($setting->agenda_target_countdown)->toDateString();
        } else {
            $tanggalDipilih = now()->toDateString();
        }

        // 2. PROSES SIMPAN KE DATABASE
        foreach ($anggotaIds as $id) {
            $anggota = \App\Models\Anggota::find($id);
            if (!$anggota) continue;

            $sudahBayar = \App\Models\Iuran::where('anggota_id', $id)
                            ->where('tanggal', $tanggalDipilih)
                            ->exists();

            if (!$sudahBayar) {
                $multiplier = isset($kelipatanInput[$id]) ? (int)$kelipatanInput[$id] : 1;

                $arisan = 5000 * $multiplier;
                $tabungan = 3000 * $multiplier;
                $dansos = ($anggota->status == 'Kerja') ? (2000 * $multiplier) : 0;

                $iuran = new \App\Models\Iuran();
                $iuran->anggota_id = $anggota->id;
                $iuran->tanggal    = $tanggalDipilih;
                $iuran->tempat     = $tempatDipilih;
                $iuran->arisan     = $arisan;
                $iuran->tabungan   = $tabungan;
                $iuran->dansos     = $dansos;
                $iuran->save();
            }
        }

        return back()->with('success', 'Data iuran berhasil disimpan ke Riwayat Arisan!');
    }

    public function publicReport()
{
    // Ambil rekapitulasi iuran untuk RT 23
    $iuranRT23 = \App\Models\Iuran::with('anggota')
        ->where('status_riwayat', 'aktif')
        ->whereHas('anggota', function($q) {
            $q->where('rt', '23');
        })->get();

    // Ambil rekapitulasi iuran untuk RT 24
    $iuranRT24 = \App\Models\Iuran::with('anggota')
        ->where('status_riwayat', 'aktif')
        ->whereHas('anggota', function($q) {
            $q->where('rt', '24');
        })->get();

    // Hitung total keseluruhan RT 23
    $totalRT23 = $iuranRT23->sum('arisan') + $iuranRT23->sum('tabungan') + $iuranRT23->sum('dansos');
    
    // Hitung total keseluruhan RT 24
    $totalRT24 = $iuranRT24->sum('arisan') + $iuranRT24->sum('tabungan') + $iuranRT24->sum('dansos');

    return view('humas.laporan', compact('iuranRT23', 'iuranRT24', 'totalRT23', 'totalRT24'));
}

    public function riwayatArisan()
    {
        // Mengambil data iuran, lalu dikelompokkan berdasarkan tanggal (per kumpulan)
        // dan langsung menjumlahkan total pendapatan (RT23 + RT24) pada hari itu
        $riwayat = \App\Models\Iuran::selectRaw('tanggal, tempat, sum(arisan + tabungan + dansos) as total_pendapatan')
                    ->groupBy('tanggal', 'tempat')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('humas.riwayat', compact('riwayat'));
    }

    public function arsipkanKumpulan()
    {
        // Mengubah semua data iuran yang masih 'aktif' menjadi 'arsip'
        \App\Models\Iuran::where('status_riwayat', 'aktif')
                        ->update(['status_riwayat' => 'arsip']);

        return back()->with('success', 'Data iuran pertemuan sebelumnya berhasil diarsipkan! Halaman utama telah direset.');
    }

    public function manajemenIuran()
{
    // 1. Ambil ID pertemuan/kumpulan terakhir yang sudah selesai
    $pertemuanTerakhir = Pertemuan::latest('tanggal')->first();

    // 2. Ambil semua data pemuda
    $daftarPemuda = Anggota::all()->map(function($pemuda) use ($pertemuanTerakhir) {
        
        // 3. Cek apakah di pertemuan terakhir, pemuda ini setorannya 0 atau tidak hadir
        $cekSetoran = Iuran::where('anggota_id', $pemuda->id)
                           ->where('pertemuan_id', $pertemuanTerakhir->id)
                           ->first();
        
        // Jika data setoran tidak ada ATAU total setorannya 0, tandai sebagai nunggak
        $pemuda->punya_tunggakan = (!$cekSetoran || $cekSetoran->total_setoran == 0) ? true : false;
        
        return $pemuda;
    });

    return view('humas.manajemen_iuran', compact('daftarPemuda'));
}
}