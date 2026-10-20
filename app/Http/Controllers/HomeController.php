<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingWeb;
use App\Models\Galeri;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil pengaturan dari tabel setting_webs
        $settings = SettingWeb::pluck('value', 'key')->toArray();
        $galeris = Galeri::latest()->get();

        $agendaTerdekat = [
            'nama' => $settings['agenda_nama'] ?? 'Kumpulan Rutin Malam Minggu Pon',
            'lokasi' => $settings['agenda_lokasi'] ?? 'Kediaman Bapak RT 01',
            'waktu' => $settings['agenda_waktu'] ?? 'Pukul 19.30 WIB',
            'tanggal' => $settings['agenda_tanggal'] ?? '25',
            'bulan' => $settings['agenda_bulan'] ?? 'OKTOBER',
            'full_date' => $settings['agenda_full_date'] ?? '2026-10-25 19:30:00',
        ];

        $statAnggota = $settings['stat_anggota'] ?? User::count();
        $statKas = $settings['stat_kas'] ?? '100%';
        $statSosial = $settings['stat_sosial'] ?? '36+';

        return view('welcome', compact('agendaTerdekat', 'statAnggota', 'statKas', 'statSosial'));
    }
}