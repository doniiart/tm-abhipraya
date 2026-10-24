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
use App\Http\Controllers\DansosController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\ArisanController;

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

    $total_kegiatan = \App\Models\Galeri::count();
    // 2. PASTIKAN 'galeris' IKUT DIKIRIM KE DALAM COMPACT
    return view('welcome', compact('agendaTerdekat', 'statAnggota', 'statKas', 'statSosial', 'galeris', 'total_kegiatan'));
});

Route::get('/laporan/bendahara', function () {
        // Ambil data total untuk publik
        $totalTabungan = \App\Models\Iuran::sum('tabungan');
        $totalKompensasi = \App\Models\Kompensasi::sum('nominal');
        
        // (Opsional) Ambil riwayat kompensasi jika ingin ditampilkan ke publik
        $riwayatKompensasi = \App\Models\Kompensasi::orderBy('tanggal', 'desc')->get();

        return view('bendahara.bendahara', compact('totalTabungan', 'totalKompensasi', 'riwayatKompensasi'));
    })->name('public.bendahara');

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
    $totalKompensasi = \App\Models\Kompensasi::sum('nominal');
    
    return view('dashboard', compact('settings', 'anggotaRT23', 'anggotaRT24', 'totalArisan', 'totalTabungan', 'totalDansos', 'totalKompensasi'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/kumpulan', [MeetingController::class, 'index'])->name('meetings.index');
    Route::post('/kumpulan', [MeetingController::class, 'store'])->name('meetings.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/persewaan/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::post('/persewaan/aset', [AsetController::class, 'store'])->name('aset.store');
    Route::put('/persewaan/aset/{id}', [AsetController::class, 'update'])->name('aset.update');
    Route::delete('/persewaan/aset/{id}', [AsetController::class, 'destroy'])->name('aset.destroy');
    Route::get('/persewaan/sewa', [SewaController::class, 'index'])->name('sewa.index');
    Route::post('/persewaan/sewa', [SewaController::class, 'store'])->name('sewa.store');
    Route::put('/persewaan/sewa/{id}/kembalikan', [SewaController::class, 'kembalikan'])->name('sewa.kembalikan');
    Route::delete('/persewaan/sewa/{id}', [SewaController::class, 'destroy'])->name('sewa.destroy');
    Route::get('/profil/edit', [App\Http\Controllers\ProfilController::class, 'edit']);
    Route::get('/profil', function () {
    // Ambil baris pertama dari tabel setting_webs
    $settings = \App\Models\SettingWeb::first(); 
    
    // Kirim variabel $settings ke tampilan profil.blade.php
    return view('profil', compact('settings')); 
});
    Route::get('/arisan/dashboard', [ArisanController::class, 'index'])->name('arisan.dashboard');
    Route::post('/arisan/simpan', [\App\Http\Controllers\ArisanController::class, 'simpanLaporan'])->name('arisan.simpan');
    Route::get('/arisan/riwayat', [\App\Http\Controllers\ArisanController::class, 'riwayat'])->name('arisan.riwayat');
});

Route::middleware(['auth', 'role:bendahara'])->prefix('admin')->group(function () {
    Route::get('/keuangan', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/keuangan', [FinanceController::class, 'store'])->name('finance.store');
    Route::get('/tabungan', function () {
        // Ambil data iuran yang kolom tabungannya lebih dari 0, urutkan dari yang terbaru
        $riwayatTabungan = \App\Models\Iuran::where('tabungan', '>', 0)
                            ->orderBy('tanggal', 'desc')
                            ->get();
                            
        return view('bendahara.tabungan', compact('riwayatTabungan'));
    })->name('bendahara.tabungan');
    Route::get('/kompensasi', [\App\Http\Controllers\KompensasiController::class, 'index'])->name('bendahara.kompensasi');
    Route::post('/kompensasi', [\App\Http\Controllers\KompensasiController::class, 'store'])->name('bendahara.kompensasi.store');
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
Route::middleware(['auth', 'role:ketua,bendahara,dansos'])->group(function () {
    Route::get('/galeri', [App\Http\Controllers\GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [App\Http\Controllers\GaleriController::class, 'store'])->name('galeri.store');
    Route::delete('/galeri/{galeri}', [App\Http\Controllers\GaleriController::class, 'destroy'])->name('galeri.destroy');
});

Route::get('/humas/manajemen', [HumasController::class, 'index'])->name('humas.index');
Route::post('/humas/iuran', [HumasController::class, 'storeIuran'])->name('humas.iuran.store');
Route::get('/laporan/humas', [HumasController::class, 'publicReport'])->name('laporan.humas');
Route::get('/laporan/humas/riwayat', [\App\Http\Controllers\HumasController::class, 'riwayatArisan'])->name('humas.riwayat');
Route::get('/laporan/dansos', [App\Http\Controllers\DansosController::class, 'laporanPublik'])->name('laporan.dansos');
Route::post('/humas/arsipkan', [\App\Http\Controllers\HumasController::class, 'arsipkanKumpulan'])->name('humas.arsipkan');
Route::get('/laporan/persewaan', [App\Http\Controllers\AsetController::class, 'laporanPublik'])->name('laporan.persewaan');
Route::get('/kegiatan-sosial', [App\Http\Controllers\GaleriController::class, 'halamanPublik'])->name('kegiatan.publik');


Route::middleware(['auth'])->group(function () {
    Route::get('/pengumuman/buat', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman/kirim', [PengumumanController::class, 'send'])->name('pengumuman.send');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dansos/pengeluaran', [DansosController::class, 'index'])->name('dansos.pengeluaran');
    Route::post('/dansos/pengeluaran', [DansosController::class, 'store'])->name('dansos.pengeluaran.store');
    Route::delete('/dansos/pengeluaran/{id}', [DansosController::class, 'destroy'])->name('dansos.pengeluaran.destroy');
    Route::get('/dansos/talangan', [DansosController::class, 'talanganIndex'])->name('dansos.talangan');
    Route::post('/dansos/talangan', [DansosController::class, 'talanganStore'])->name('dansos.talangan.store');
    Route::delete('/dansos/talangan/{id}', [DansosController::class, 'talanganDestroy'])->name('dansos.talangan.destroy');
});

require __DIR__.'/auth.php';
