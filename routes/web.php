<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebsiteSettingController;
use App\Models\SettingWeb;
use App\Models\Galeri;
use App\Http\Controllers\HumasController;
use App\Http\Controllers\PengumumanController;

Route::get('/', function () {
    $settings = SettingWeb::first();
    
    // 1. TAMBAHKAN BARIS INI: Ambil semua data galeri dari database
    $galeris = Galeri::latest()->get(); 

    // Data agenda dan statistik yang sudah Anda miliki
    $agendaTerdekat = [
        'nama' => $settings->agenda_nama ?? 'Belum ada agenda',
        'lokasi' => $settings->agenda_lokasi ?? '-',
        'waktu' => $settings->agenda_waktu ?? '-',
        'tanggal' => $settings->agenda_tanggal ?? '00',
        'bulan' => $settings->agenda_bulan ?? '...',
        'full_date' => $settings->agenda_target_countdown ?? now()->addDays(7)->format('Y-m-d H:i:s'),
    ];

    $statAnggota = $settings->stat_anggota ?? '0';
    $statKas = $settings->stat_kas ?? '0%';
    $statSosial = $settings->stat_sosial ?? '0+';

    // 2. PASTIKAN 'galeris' IKUT DIKIRIM KE DALAM COMPACT
    return view('welcome', compact('agendaTerdekat', 'statAnggota', 'statKas', 'statSosial', 'galeris'));
});

Route::get('/anggota', [\App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.index');

Route::get('/profil', function () { return view('profil'); });
Route::get('/kegiatan', function () { return view('kegiatan'); });

Route::get('/dashboard', function () {
    // Ambil data pengaturan
    $settings = \App\Models\SettingWeb::first();
    
    // Ambil data anggota
    $anggotaRT23 = \App\Models\Anggota::where('rt', '23')->get();
    $anggotaRT24 = \App\Models\Anggota::where('rt', '24')->get();
    
    // Hitung total uang di database
    $totalArisan = \App\Models\Iuran::sum('arisan');
    $totalTabungan = \App\Models\Iuran::sum('tabungan');
    $totalDansos = \App\Models\Iuran::sum('dansos');
    
    return view('dashboard', compact('settings', 'anggotaRT23', 'anggotaRT24', 'totalArisan', 'totalTabungan', 'totalDansos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/kumpulan', [MeetingController::class, 'index'])->name('meetings.index');
    Route::post('/kumpulan', [MeetingController::class, 'store'])->name('meetings.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:bendahara'])->prefix('admin')->group(function () {
    Route::get('/keuangan', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/keuangan', [FinanceController::class, 'store'])->name('finance.store');
});

Route::middleware(['auth', 'role:petugas-laporan,tata-usaha'])->prefix('admin')->group(function () {
    Route::post('/usulan', [ProposalController::class, 'store'])->name('proposals.store');
    Route::patch('/usulan/{proposal}', [ProposalController::class, 'updateStatus'])->name('proposals.updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/web-settings', [WebsiteSettingController::class, 'edit'])->name('admin.settings.edit');
    Route::post('/admin/web-settings', [WebsiteSettingController::class, 'update'])->name('admin.settings.update');
});

// Rute khusus Galeri - Hanya Ketua, Bendahara, Dansos, dan Anggota
Route::middleware(['auth', 'role:ketua|bendahara|dansos|anggota'])->group(function () {
    Route::get('/galeri', [App\Http\Controllers\GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [App\Http\Controllers\GaleriController::class, 'store'])->name('galeri.store');
    Route::delete('/galeri/{galeri}', [App\Http\Controllers\GaleriController::class, 'destroy'])->name('galeri.destroy');
});

Route::get('/humas/manajemen', [HumasController::class, 'index'])->name('humas.index');
Route::post('/humas/iuran', [HumasController::class, 'storeIuran'])->name('humas.iuran.store');
Route::get('/laporan/humas', [HumasController::class, 'publicReport'])->name('laporan.humas');
Route::get('/laporan/humas/riwayat', [\App\Http\Controllers\HumasController::class, 'riwayatArisan'])->name('humas.riwayat');


Route::middleware(['auth'])->group(function () {
    Route::get('/pengumuman/buat', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman/kirim', [PengumumanController::class, 'send'])->name('pengumuman.send');
});


require __DIR__.'/auth.php';
