@php
    $saldoKompensasiKemarin = DB::table('kompensasis')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') < ?", [$bulanIni])
            ->sum('nominal'); // Sesuaikan 'nominal' dan 'tanggal' jika nama kolomnya beda

        // 2. Ambil Tambahan Saldo Kompensasi Bulan Ini
        $tambahKompensasiBulanIni = DB::table('kompensasis')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->sum('nominal');

        // 3. Total Saldo Kompensasi Saat Ini
        $totalKompensasi = $saldoKompensasiKemarin + $tambahKompensasiBulanIni;

    $bulanIni = \Carbon\Carbon::now()->format('Y-m');
    $bulanKemarin = \Carbon\Carbon::now()->subMonth()->format('Y-m');

    // 1. Ambil Total Tabungan Bulan Kemarin (Gabungan)
    $tabunganBulanKemarin = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanKemarin])
        ->sum('tabungan');
        
    // 2. Ambil Setoran Tabungan Candi Bulan Ini
    // Sesuaikan 'wilayah' dengan nama kolom di database Mas Doni (misal: 'wilayah', 'rt', atau 'kategori')
    $tabunganCandiBulanIni = DB::table('iurans')
        ->join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
        ->where('anggotas.rt', '23') 
        ->whereRaw("DATE_FORMAT(iurans.tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('iurans.tabungan');
        
    // 3. Ambil Setoran Tabungan Gunung Bulan Ini
    $tabunganGunungBulanIni = DB::table('iurans')
        ->join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
        ->where('anggotas.rt', '24') 
        ->whereRaw("DATE_FORMAT(iurans.tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('iurans.tabungan');

    // 4. Hitung Total Tabungan Bulan Ini (Candi + Gunung)
    $tabunganBulanIniTotal = $tabunganCandiBulanIni + $tabunganGunungBulanIni;

    // --- RUMUS SALDO BULAN KEMARIN (TABUNGAN) ---
    // Mengambil semua tabungan dari bulan-bulan sebelumnya yang statusnya sudah 'selesai'
    $saldoTabunganBulanKemarin = \App\Models\Iuran::where('status_riwayat', 'selesai')->sum('tabungan');
@endphp

<!-- Grid Utama: Dibagi 2 Kolom Besar (Sisi Kiri untuk Tabungan & Kompensasi, Sisi Kanan untuk Kas Muda & Kas Tua) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-2 mb-2">

    <!-- ========================================== -->
    <!-- SISI KIRI (Porsi lebih besar - 7 kolom)    -->
    <!-- ========================================== -->
    <div class="lg:col-span-7 flex flex-col gap-2">
        
        <!-- 1. KARTU TABUNGAN -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-2">Tabungan</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sisi Kiri Tabungan: Total Saldo Bulan Ini -->
                <div>
                    <p class="text-xs text-slate-500 font-medium mb-1">Tabungan Bulan Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($totalTabunganBulanIni - \App\Models\PengeluaranBendahara::sum('nominal'), 0, ',', '.') }}</h3>
                    <a href="{{ route('bendahara.tabungan') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mt-2 inline-block">Rincian Tabungan &rarr;</a>
                </div>
                
                <!-- Sisi Kanan Tabungan: Area Rincian -->
                <div class="border-t md:border-t-0 md:border-l border-slate-100 pt-3 md:pt-0 md:pl-4 flex flex-col justify-center space-y-2">
                    <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                        <span class="text-slate-500">Saldo Bulan Kemarin:</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($saldoTabunganBulanKemarin, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                        <span class="text-slate-500">Setoran Candi:</span>
                        <span class="font-bold text-emerald-600">+ Rp {{ number_format($tabunganCandi, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px]">
                        <span class="text-slate-500">Setoran Gunung:</span>
                        <span class="font-bold text-emerald-600">+ Rp {{ number_format($tabunganGunung, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
    <!-- SISI KANAN (Porsi lebih kecil - 5 kolom)   -->
    <!-- ========================================== -->
    <div class="lg:col-span-5 flex flex-col gap-2">
        
        <!-- 2. KARTU KAS MUDA -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS MUDA</span>
            </div>
            
            <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($kasMuda ?? 0, 0, ',', '.') }}</h3>
            
            <div class="mt-4 pt-4 border-t border-slate-100">
                @if(auth()->user()->hasAnyRole(['bendahara', 'super-admin']))
                    <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center transition-colors">
                        Kelola Kas Muda &rarr;
                    </a>
                @else
                    <span class="text-xs font-bold text-slate-400">Akses Hanya Baca</span>
                @endif
            </div>
        </div>

        <!-- 3. KARTU KAS TUA -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-indigo-50 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS TUA</span>
            </div>
            
            <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($kasTua ?? 0, 0, ',', '.') }}</h3>
            
            <div class="mt-4 pt-4 border-t border-slate-100">
                @if(auth()->user()->hasAnyRole(['bendahara', 'super-admin']))
                    <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center transition-colors">
                        Kelola Kas Tua &rarr;
                    </a>
                @else
                    <span class="text-xs font-bold text-slate-400">Akses Hanya Baca</span>
                @endif
            </div>
        </div>

    </div>

        <!-- 4. KARTU KOMPENSASI -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-2">Kompensasi</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sisi Kiri Kompensasi: Total Saldo Ini -->
                <div>
                    <p class="text-xs text-slate-500 font-medium mb-1">Total Saldo Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($totalKompensasi ?? 0, 0, ',', '.') }}</h3>
                    <a href="{{ route('bendahara.kompensasi') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 mt-2 inline-block">Cek Riwayat &rarr;</a>
                </div>
                
                <!-- Sisi Kanan Kompensasi: Area Rincian -->
                <div class="border-t md:border-t-0 md:border-l border-slate-100 pt-3 md:pt-0 md:pl-4 flex flex-col justify-center space-y-2">
                    <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                        <span class="text-slate-500">Saldo Bln Kemarin:</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($saldoKompensasiKemarin ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                        <span class="text-slate-500">Tambah Bln Ini:</span>
                        <span class="font-bold text-orange-600">+ Rp {{ number_format($tambahKompensasiBulanIni ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[11px]">
                        <span class="text-slate-500">Total Saldo Ini:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalKompensasi ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. KARTU PENGELUARAN BENDAHARA -->
        <div onclick="bukaModalPengeluaran()" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative mt-4 hover:shadow-md hover:border-red-200 transition-all cursor-pointer group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                    <!-- Ikon Pengeluaran -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-2">Pengeluaran</span>
            </div>
            
            <div>
                <p class="text-xs text-slate-500 font-medium mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                    <!-- Menampilkan total uang keluar secara otomatis -->
                    Rp {{ number_format(\App\Models\PengeluaranBendahara::sum('nominal'), 0, ',', '.') }}
                </h3>
                
                <!-- MEMUNCULKAN DAFTAR CATATAN PENGELUARAN DI SINI -->
                <div class="mt-3 space-y-3">
                    <!-- Teks Perintah Sesuai Instruksi -->
                    <p class="text-xs font-bold text-red-500 mt-2">&plusmn; Klik area ini untuk mencatat pengeluaran</p>
                    
                    <!-- TOMBOL KE HALAMAN RINCIAN PENGELUARAN -->
                    <!-- event.stopPropagation() mencegah pop-up modal ikut terbuka saat tombol ini diklik -->
                    <a href="{{ route('bendahara.pengeluaran.index') }}" onclick="event.stopPropagation()" class="mt-4 block text-center text-xs font-bold text-indigo-500 hover:text-indigo-600 bg-indigo-50 py-2.5 rounded-xl border border-indigo-100 transition-colors">
                        Lihat Rincian Pengeluaran &rarr;
                    </a>
                </div>
                
            </div>
        </div>

    </div>

    
</div>

<div id="modalPengeluaran" class="fixed inset-0 z-50 hidden">
    <!-- Background Gelap & Blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="tutupModalPengeluaran()"></div>
    
    <!-- Kotak Form -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
                
                <form action="{{ route('bendahara.pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pb-6 pt-8 sm:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800">Catat Pengeluaran</h3>
                                <p class="text-sm text-slate-500">Masukkan rincian dana yang keluar.</p>
                            </div>
                        </div>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Hari / Tanggal</label>
                                <input type="date" name="tanggal" required class="w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 transition-all text-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Nominal (Rp)</label>
                                <input type="number" name="nominal" required class="w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 transition-all text-slate-700" placeholder="Contoh: 150000">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Untuk Keperluan</label>
                                <textarea name="keperluan" required class="w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 transition-all text-slate-700" rows="3" placeholder="Contoh: Pembelian buku kas dan bolpoin"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="tutupModalPengeluaran()" class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl shadow-sm hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl shadow-sm hover:bg-red-500 hover:shadow-md transition-all">
                            Simpan Pengeluaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function bukaModalPengeluaran() {
        document.getElementById('modalPengeluaran').classList.remove('hidden');
    }

    function tutupModalPengeluaran() {
        document.getElementById('modalPengeluaran').classList.add('hidden');
    }
</script>