@php
    use Illuminate\Support\Facades\DB;

    // 1. Definisikan bulannya terlebih dahulu di paling atas!
    $bulanIni = \Carbon\Carbon::now()->format('Y-m');
    $bulanKemarin = \Carbon\Carbon::now()->subMonth()->format('Y-m');

    // 2. Baru jalankan query-nya
    $tabunganBulanIniTotal = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('tabungan');

    $tabunganBulanKemarin = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanKemarin])
        ->sum('tabungan');
        
    $tabunganCandiBulanIni = DB::table('iurans')
        ->join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
        ->where('anggotas.rt', '23') 
        ->whereRaw("DATE_FORMAT(iurans.tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('iurans.tabungan');

    $tabunganGunungBulanIni = DB::table('iurans')
        ->join('anggotas', 'iurans.anggota_id', '=', 'anggotas.id')
        ->where('anggotas.rt', '24') 
        ->whereRaw("DATE_FORMAT(iurans.tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('iurans.tabungan');

        // 1. Ambil Saldo Kompensasi Bulan Kemarin (Semua saldo sebelum bulan ini)
    $saldoKompensasiKemarin = DB::table('kompensasis')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') < ?", [$bulanIni])
        ->sum('nominal'); // Pastikan nama kolom 'nominal' sesuai dengan di database

    // 2. Ambil Tambahan Saldo Kompensasi Bulan Ini
    $tambahKompensasiBulanIni = DB::table('kompensasis')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('nominal');

    // 3. Total Saldo Kompensasi Saat Ini
    $totalKompensasi = $saldoKompensasiKemarin + $tambahKompensasiBulanIni;
@endphp

<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Publik -->
            <div class="mb-8">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Transparansi Keuangan</span>
                <!-- Tombol Kembali ke Menu -->
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Laporan Bendahara</h1>
                <p class="text-sm text-slate-500 mt-1">Rincian saldo kas, tabungan pemuda, dan dana kompensasi Karang Taruna.</p>
                <span class="mt-8 text-center">
                <a href="{{ url('/') }}#bagian-laporan" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    &larr; Kembali ke Menu Utama
                </a>
            </span>
            </div>

            <!-- Grid 4 Kartu Kas (Versi Publik) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
                
                <!-- Kartu Tabungan -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
    
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-2">Tabungan</span>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Total Saldo Karang Taruna</p>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($tabunganBulanIniTotal, 0, ',', '.') }}</h3>
                        
                        <!-- Teks yang bisa diklik -->
                        <button type="button" onclick="toggleRincian()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mt-2 flex items-center gap-1 cursor-pointer focus:outline-none transition-colors">
                            <span id="teks-tombol">Lihat Rincian</span>
                            <!-- Ikon Panah -->
                            <svg id="ikon-panah" class="w-3 h-3 transition-transform duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Area Rincian (Animasi Smooth: max-h-0 -> max-h-40) -->
                    <div id="rincian-tabungan" class="grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr;">
                        <!-- Tambahkan div pembungkus overflow-hidden ini -->
                        <div class="overflow-hidden">
                            <div class="border-t border-slate-100 pt-3 mt-4 flex flex-col justify-center space-y-2">
                                <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                                    <span class="text-slate-500">Saldo Bulan Kemarin:</span>
                                    <span class="font-bold text-slate-700">Rp {{ number_format($tabunganBulanKemarin, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-slate-500">Setoran Candi:</span>
                                    <span class="font-bold text-emerald-600">+ Rp {{ number_format($tabunganCandiBulanIni, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-slate-500">Setoran Gunung:</span>
                                    <span class="font-bold text-emerald-600">+ Rp {{ number_format($tabunganGunungBulanIni, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Kas Muda (Sementara Rp 0) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm opacity-75">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS MUDA</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp 0</h3>
                </div>

                <!-- Kartu Kas Tua (Sementara Rp 0) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm opacity-75">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-indigo-50 text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS TUA</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp 0</h3>
                </div>

                <!-- Kartu Kompensasi -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-orange-50 text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KOMPENSASI</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Dana Pemasukan Luar</p>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($totalKompensasi, 0, ',', '.') }}</h3>

                        <!-- Teks yang bisa diklik (Warna Oranye) -->
                        <button type="button" onclick="toggleRincianKompensasi()" class="text-xs font-bold text-orange-600 hover:text-orange-700 mt-2 flex items-center gap-1 cursor-pointer focus:outline-none transition-colors">
                            <span id="teks-tombol-komp">Lihat Rincian</span>
                            <!-- Ikon Panah -->
                            <svg id="ikon-panah-komp" class="w-3 h-3 transition-transform duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Area Rincian Kompensasi (Animasi Smooth Pakai Grid) -->
                    <div id="rincian-kompensasi" class="grid transition-all duration-500 ease-in-out" style="grid-template-rows: 0fr;">
                        <div class="overflow-hidden">
                            <div class="border-t border-slate-100 pt-3 mt-4 flex flex-col justify-center space-y-2">
                                <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                                    <span class="text-slate-500">Saldo Bln Kemarin:</span>
                                    <span class="font-bold text-slate-700">Rp {{ number_format($saldoKompensasiKemarin, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px] pb-1 border-b border-dashed border-slate-200">
                                    <span class="text-slate-500">Tambah Bln Ini:</span>
                                    <span class="font-bold text-orange-600">+ Rp {{ number_format($tambahKompensasiBulanIni, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-slate-500">Total Saldo Ini:</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($totalKompensasi, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            
            </div>

        </div>
    </div>

    <script>
        function toggleRincian() {
            const rincianDiv = document.getElementById('rincian-tabungan');
            const ikon = document.getElementById('ikon-panah');
            const teks = document.getElementById('teks-tombol');

            // Putar ikon panah
            ikon.classList.toggle('rotate-180');
            
            // Cek style inline grid-template-rows
            if (rincianDiv.style.gridTemplateRows === '0fr') {
                // Buka rincian
                rincianDiv.style.gridTemplateRows = '1fr';
                teks.innerText = 'Tutup Rincian';
            } else {
                // Tutup rincian
                rincianDiv.style.gridTemplateRows = '0fr';
                teks.innerText = 'Lihat Rincian';
            }
        }

        function toggleRincianKompensasi() {
        // Ambil elemen berdasarkan ID khusus kompensasi
        const rincianDiv = document.getElementById('rincian-kompensasi');
        const ikon = document.getElementById('ikon-panah-komp');
        const teks = document.getElementById('teks-tombol-komp');

        // Putar ikon panah
        ikon.classList.toggle('rotate-180');
        
        // Animasi buka-tutup pakai grid
        if (rincianDiv.style.gridTemplateRows === '0fr') {
            rincianDiv.style.gridTemplateRows = '1fr';
            teks.innerText = 'Tutup Rincian';
        } else {
            rincianDiv.style.gridTemplateRows = '0fr';
            teks.innerText = 'Lihat Rincian';
        }
}
    </script>
</x-app-layout>