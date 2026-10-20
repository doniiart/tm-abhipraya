<?php

namespace App\Http\Controllers;

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
        
        // 1. TAMBAHKAN BARIS INI UNTUK MENGAMBIL DATA AGENDA
        $agendas = \App\Models\MeetingAgenda::orderBy('tanggal', 'desc')->get();

        // 2. TAMBAHKAN 'agendas' DI DALAM COMPACT
       return view('dashboard', compact('anggotaRT23', 'anggotaRT24', 'agendas'));
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
        ->whereHas('anggota', function($q) {
            $q->where('rt', '23');
        })->get();

    // Ambil rekapitulasi iuran untuk RT 24
    $iuranRT24 = \App\Models\Iuran::with('anggota')
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
}