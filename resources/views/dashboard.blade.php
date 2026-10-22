@php
    use Illuminate\Support\Facades\DB;

    $bulanIni = \Carbon\Carbon::now()->format('Y-m');
    $tabunganBulanIniTotal = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('tabungan');

    // Total Arisan Bulan Ini
    $arisanBulanIniTotal = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('arisan');

    // Total Dansos Bulan Ini
    $dansosBulanIniTotal = DB::table('iurans')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('dansos');

    $bulanIni = \Carbon\Carbon::now()->format('Y-m');
    
    $pemasukanBulanIni = DB::table('iurans')->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])->sum('dansos');
    $pemasukanBulanKemarin = DB::table('iurans')->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') < ?", [$bulanIni])->sum(DB::raw('dansos + arisan'));

    $pengeluaranList = DB::table('pengeluaran_dansos')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->orderBy('tanggal', 'desc')
        ->get();

    $pengeluaranSakitTakziah = $pengeluaranList->sum('nominal'); 
    $talanganTabungan = DB::table('talangan_dansos')
        ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
        ->sum('nominal');

    $totalSaldoDansos = ($pemasukanBulanKemarin + $pemasukanBulanIni) - $pengeluaranSakitTakziah + $talanganTabungan;
@endphp
<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-extrabold text-2xl text-gray-900 tracking-tight">
                {{ __('Dashboard Organisasi') }}
            </h2>
            <p class="text-sm text-gray-500 font-medium mt-1 md:mt-0">
                Sistem Informasi Karang Taruna Tunas Muda Abhipraya
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Ucapan Selamat Datang Mewah -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl shadow-2xl overflow-hidden mb-8 relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-red-500 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-2xl opacity-20"></div>
                
                <div class="relative p-8 md:p-10 flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <p class="text-yellow-400 font-bold tracking-widest text-xs uppercase mb-1">
                            Akses: {{ Auth::user()->roles->first()->name ?? 'Anggota Biasa' }}
                        </p>
                        <h3 class="text-3xl md:text-4xl font-black text-white mb-2">
                            Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                        </h3>
                        <p class="text-gray-300 font-medium max-w-xl">
                            Selamat datang di panel kerja Anda. Berikut adalah ringkasan aktivitas dan tugas terbaru yang perlu Anda perhatikan hari ini.
                        </p>
                    </div>
                    <div class="mt-6 md:mt-0">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center">
                            <p class="text-xs text-gray-300 font-semibold uppercase tracking-wider mb-1">Status Sistem</p>
                            <p class="text-lg font-bold text-green-400 flex items-center justify-center gap-2">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                </span>
                                Online Aman
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BENTO GRID SYSTEM: Konten Dinamis Berdasarkan Role -->
            <div class="max-w-3xl mx-auto flex flex-col gap-6">

                {{-- ========================================== --}}
                {{-- KHUSUS BENDAHARA                           --}}
                {{-- ========================================== --}}
                @if(auth()->user()->hasAnyRole(['bendahara']))
                    @include('bendahara.dashboard')
                @endif
                {{-- ========================================== --}}
                {{-- KHUSUS DANSOS (DANA SOSIAL)                --}}
                {{-- ========================================== --}}
                @if(auth()->user()->hasAnyRole(['dansos']))
                    <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 mb-4 relative overflow-hidden">
                    <!-- Hiasan Background -->
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>

                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 border border-red-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 tracking-widest uppercase">Dana Sosial</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-slate-500 mb-1">Total Saldo Dansos Tersisa</p>
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            Rp {{ number_format($totalSaldoDansos, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

            <div class="flex flex-col gap-2">
                <!-- GRID RINCIAN ARUS KAS DANSOS -->
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Kartu 1: Bulan Kemarin -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Bulan Kemarin</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mb-1 line-clamp-1">Total Dansos + Arisan</p>
                        <h4 class="text-sm sm:text-base font-bold text-slate-800">
                            Rp {{ number_format($pemasukanBulanKemarin, 0, ',', '.') }}
                        </h4>
                    </div>

                    <!-- Kartu 2: Pemasukan Bulan Ini -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Bulan Ini</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mb-1 line-clamp-1">Setoran kedua Humas</p>
                        <h4 class="text-sm sm:text-base font-bold text-emerald-600">
                            + Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
                        </h4>
                    </div>

                    <!-- Kartu 3: Pengeluaran Sakit & Takziah -->
                    <a href="{{ url('/dansos/pengeluaran') }}" class="block bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm hover:border-red-300 hover:shadow-md transition-all duration-200 group cursor-pointer">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 rounded-full bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pengeluaran</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mb-1 line-clamp-1">Klik untuk kelola data</p>
                        <h4 class="text-sm sm:text-base font-bold text-red-500">
                            - Rp {{ number_format($pengeluaranSakitTakziah, 0, ',', '.') }}
                        </h4>
                    </a>

                    <!-- Kartu 4: Dana Talangan / Tabungan -->
                    <a href="{{ route('dansos.talangan') }}" class="block bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm hover:border-amber-300 hover:shadow-md transition-all duration-200 group cursor-pointer">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Talangan</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mb-1 line-clamp-1">Klik untuk kelola data</p>
                        <h4 class="text-sm sm:text-base font-bold text-slate-800">
                            Rp {{ number_format($talanganTabungan, 0, ',', '.') }}
                        </h4>
                    </a>

                </div>
                @endif

                {{-- ========================================== --}}
                {{-- KHUSUS TATA USAHA & SUPER ADMIN            --}}
                {{-- ========================================== --}}
                @if(auth()->user()->hasRole('tata-usaha') || auth()->user()->hasRole('super-admin'))
                    <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-yellow-50 text-yellow-600 p-3 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Anggota</span>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Terdaftar</p>
                        <p class="text-lg font-extrabold text-slate-800 mt-0.5">
                            {{ \App\Models\Anggota::count() }} 
                            <span class="text-sm font-normal text-slate-500">Pemuda</span>
                        </p>
                        <a href="{{ route('anggota.index') }}" class="text-yellow-600 text-sm font-bold hover:text-yellow-700 flex items-center gap-1">
                            Lihat Daftar Anggota <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @endif

                <!-- Menu Manajemen Galeri (Hanya tampil untuk role tertentu) -->
    

                {{-- ========================================== --}}
                {{-- KHUSUS HUMAS                               --}}
                {{-- ========================================== --}}`

                @if(Auth::user()->rt_akses == 'all')
                    <!-- KARTU GABUNGAN KHUSUS KETUA -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-yellow-400 text-lg">
                                    📊
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Humas Candi & Gunung</h3>
                                    <p class="text-xs text-slate-500">Rekapitulasi Iuran Pemuda RT 23 & RT 24</p>
                                </div>
                            </div>
                            <a href="{{ url('/laporan/humas') }}" class="text-xs font-bold text-yellow-400 hover:text-yellow-400 border border-amber-200 bg-amber-50/50 px-3 py-1.5 rounded-lg transition-all">
                                Laporan Resmi →
                            </a>
                        </div>

                        <!-- Detail Nominal Gabungan -->
                        <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-100 text-center sm:text-left">
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Arisan</p>
                                <p class="text-lg font-extrabold text-slate-800 mt-0.5">Rp {{ number_format($arisanBulanIniTotal, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Tabungan</p>
                                <p class="text-lg font-extrabold text-slate-800 mt-0.5">Rp {{ number_format($tabunganBulanIniTotal, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dansos</p>
                                <p class="text-lg font-extrabold text-slate-800 mt-0.5">Rp {{ number_format($dansosBulanIniTotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="w-full">
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 w-full">
                            <div class="flex justify-between items-center mb-6">
                                <div class="bg-yellow-100 text-yellow-700 p-3 rounded-2xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Informasi</span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Notifikasi Push</p>
                            <h4 class="text-3xl font-black text-gray-900 mb-4">Siap Kirim</h4>
                            <a href="{{ route('pengumuman.create') }}" class="text-yellow-600 text-sm font-bold hover:text-yellow-800 flex items-center gap-1">
                                Buat Pengumuman <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @if(auth()->user()->hasRole('dansos'))
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            Riwayat Pengeluaran Bulan Ini
                        </h4>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($pengeluaranList as $item)
                        <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                            <span class="text-slate-600 flex flex-col sm:flex-row sm:gap-1">
                                <span class="font-semibold text-slate-700">
                                    {{ $item->jenis == 'Sakit' ? 'Menjenguk' : 'Takziah ke' }}
                                </span> 
                                <span class="text-slate-500">{{ $item->keterangan }}</span>
                            </span>
                            <span class="font-bold text-red-500 bg-red-50 px-2 py-1 rounded-lg text-xs whitespace-nowrap">
                                - Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif


                @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('dansos') || auth()->user()->hasRole('anggota'))
    <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-slate-100 text-slate-900 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-700">Manajemen Galeri</h3>
            </div>
            <p class="text-sm text-gray-500 mb-4">Unggah dan kelola foto dokumentasi kegiatan Karang Taruna.</p>
        </div>
        <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-slate-700">
            Buka Galeri 
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>
    @endif

                {{-- ========================================== --}}
                {{-- UNTUK SEMUA (ANGGOTA & PENGURUS)           --}}
                {{-- WIDGET JADWAL KUMPULAN                     --}}
                {{-- ========================================== --}}
                
                <div class="md:col-span-2 lg:col-span-2 bg-white rounded-2xl p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden mb-4">
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-gray-50 to-transparent pointer-events-none"></div>
                    
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Agenda Terdekat</h3>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                        <div class="text-center bg-gray-50 rounded-xl p-4 border border-gray-100 min-w-[80px]">
                            <div class="text-2xl font-bold text-gray-900">{{ $settings->agenda_tanggal ?? '00' }}</div>
                            <div class="text-xs font-semibold text-red-600 uppercase">{{ $settings->agenda_bulan ?? '...' }}</div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-900">{{ $settings->agenda_nama ?? 'Belum ada agenda' }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $settings->agenda_waktu ?? '-' }} • {{ $settings->agenda_lokasi ?? '-' }}</p>
                            
                            <!-- Tombol Ubah (sesuaikan route jika berbeda) -->
                           @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('humas'))
                                <a href="{{ route('admin.settings.edit') }}#agenda-form" class="inline-block mt-3 px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors">
                                    Ubah Jadwal Rapat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div> <!-- End of Bento Grid -->

            {{-- TOMBOL NOTIFIKASI KHUSUS ANGGOTA BIASA --}}
            @if(auth()->user()->hasRole('anggota'))
            <div class="mt-6 bg-yellow-50 rounded-3xl p-6 border border-yellow-200/50 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-lg font-bold text-yellow-900 mb-1">🔔 Nyalakan Pengingat Otomatis</h4>
                    <p class="text-yellow-700 text-sm font-medium">Terima notifikasi di layar HP Anda saat kumpulan akan dimulai.</p>
                </div>
                <button id="tombol-notif" class="shrink-0 bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-2xl font-bold transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    Aktifkan Sekarang
                </button>
            </div>
            @endif

            <!-- ========================================== -->
<!-- MULAI BAGIAN MANAJEMEN IURAN HUMAS -->
<!-- ========================================== -->
<div class="mt-8 bg-white border border-slate-200/80 rounded-2xl p-6 shadow-2xs" 
     x-data="{ 
        activeTab: '{{ Auth::user()->rt_akses == '24' ? 'rt24' : 'rt23' }}', 
        selectedRT23: [],
        selectedRT24: [],
        totalArisan: 0, 
        totalTabungan: 0, 
        totalDansos: 0, 
        totalSemua: 0, 

        hitungRealtime() {
            let a = 0; let t = 0; let d = 0; 
            document.querySelectorAll('.iuran-checkbox:checked').forEach(cb => { 
                a += 5000; 
                t += 3000; 
                if(cb.dataset.status === 'Kerja') { 
                    d += 2000; 
                } 
            }); 
            this.totalArisan = a; 
            this.totalTabungan = t; 
            this.totalDansos = d; 
            this.totalSemua = a + t + d; 
        } 
     }">
    <!-- Notifikasi Sukses/Gagal -->
@if(session('success'))
    <div class="mb-4 p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="font-bold mr-1">Berhasil!</span> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 shadow-sm flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
        <span class="font-bold mr-1">Gagal!</span> {{ session('error') }}
    </div>
@endif

    @if(Auth::user()->rt_akses !== 'all')
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Manajemen Iuran Kumpulan</h2>
            <p class="text-sm text-gray-500 mt-1">Centang pemuda yang sudah asok iuran.</p>
            <div x-data="{ showModalArsip: false }">
                
                <!-- Form Utama (Hilangkan onsubmit bawaan) -->
                <form id="form-arsip" action="{{ route('humas.arsipkan') }}" method="POST">
                    @csrf
                    <!-- Tombol ini sekarang hanya memicu modal, bukan langsung submit -->
                    <button type="button" @click="showModalArsip = true" class="inline-flex items-center gap-2 px-6 py-3 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-extrabold text-sm rounded-xl transition-all duration-300 shadow-sm border border-red-100 hover:border-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Selesai & Arsipkan Kumpulan Ini
                    </button>
                </form>

                <!-- MODAL KONFIRMASI ESTETIK -->
                <div x-show="showModalArsip" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4">
                    
                    <!-- Backdrop Gelap dengan Efek Kaca (Blur) -->
                    <div x-show="showModalArsip" 
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click="showModalArsip = false"
                        class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
                        
                    <!-- Kotak Modal Utama -->
                    <div x-show="showModalArsip" 
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                        class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-auto overflow-hidden border border-slate-100">
                        
                        <div class="flex flex-col items-center text-center">
                            <!-- Ikon Peringatan (Merah Elegan) -->
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-5 text-red-500 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-black text-slate-800 mb-2">Tutup Buku Kumpulan?</h3>
                            <p class="text-sm text-slate-500 font-medium mb-8 leading-relaxed">
                                Data iuran bulan sebelumnya akan dipindah ke halaman Riwayat. Halaman depan akan <b>direset menjadi Rp 0</b>. Anda yakin?
                            </p>
                            
                            <div class="flex gap-3 w-full">
                                <!-- Tombol Batal -->
                                <button type="button" @click="showModalArsip = false" class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl transition-colors">
                                    Batal
                                </button>
                                <!-- Tombol Eksekusi Submit (Menggunakan $refs.formArsip.submit()) -->
                                <button type="button" onclick="document.getElementById('form-arsip').submit();" class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl transition-all shadow-[0_8px_20px_rgba(220,38,38,0.25)] hover:-translate-y-0.5">
                                    Ya, Arsipkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigasi Tab RT -->
        <div class="flex space-x-2">
            @if(Auth::user()->rt_akses == 'all' || Auth::user()->rt_akses == '23')
            <button @click="activeTab = 'rt23'" 
                    :class="{ 'bg-gray-900 text-white': activeTab === 'rt23', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeTab !== 'rt23' }" 
                    class="px-4 py-2 rounded-xl font-bold transition-all duration-200 text-sm">
                Pemuda RT 23
            </button>
            @endif
            @if(Auth::user()->rt_akses == 'all' || Auth::user()->rt_akses == '24')
            <button @click="activeTab = 'rt24'" 
                    :class="{ 'bg-gray-900 text-white': activeTab === 'rt24', 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50': activeTab !== 'rt24' }" 
                    class="px-4 py-2 rounded-xl font-bold transition-all duration-200 text-sm">
                Pemuda RT 24
            </button>
            @endif
        </div>
    </div>

            <!-- Form Simpan Iuran -->
            <form action="{{ route('humas.iuran.store') }}" method="POST">
            @csrf


            <!-- TABEL RT 23 -->
            <div x-show="activeTab === 'rt23'" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-opacity">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                        <tr>
                            <th class="py-3 px-4">NAMA PEMUDA</th>
                            <th class="py-3 px-4 text-center">STATUS</th>
                            <th class="py-3 px-4 text-center">NOMINAL WAJIB</th>
                            <th class="py-3 px-4 text-center">KELIPATAN</th>
                            <th class="py-3 px-4 text-center">
                                <label class="cursor-pointer inline-flex items-center space-x-2 select-none justify-center w-full">
                                    <input type="checkbox" onclick="document.querySelectorAll('.rt23-checkbox').forEach(cb => cb.checked = this.checked)" class="rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer">
                                    <span>PILIH SEMUA</span>
                                </label>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($anggotaRT23 as $anggota)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-bold {{ $anggota->status == 'Sekolah' ? 'text-sky-600' : 'text-slate-800' }}">
                                {{ $anggota->nama }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-medium {{ $anggota->status == 'Sekolah' ? 'bg-sky-50 text-sky-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ $anggota->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center text-slate-600 font-semibold text-sm">
                                Rp {{ $anggota->status == 'Sekolah' ? '8.000' : '10.000' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <select name="kelipatan[{{ $anggota->id }}]" class="text-xs font-bold rounded-lg border-slate-200 py-1 px-2 focus:ring-red-500 focus:border-red-500 cursor-pointer">
                                    <option value="1">1x (Normal)</option>
                                    <option value="2">2x (Double)</option>
                                    <option value="3">3x (Triple)</option>
                                </select>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" name="anggota_ids[]" value="{{ $anggota->id }}" class="rt23-checkbox rounded border-slate-300 text-red-600 focus:ring-red-500 w-4 h-4 cursor-pointer">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- TABEL RT 24 -->
            <div x-show="activeTab === 'rt24'" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-opacity" style="display: none;">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                        <tr>
                            <th class="py-3 px-4">NAMA PEMUDA</th>
                            <th class="py-3 px-4 text-center">STATUS</th>
                            <th class="py-3 px-4 text-center">NOMINAL WAJIB</th>
                            <th class="py-3 px-4 text-center">KELIPATAN</th>
                            <th class="py-3 px-4 text-center">
                                <label class="cursor-pointer inline-flex items-center space-x-2 select-none justify-center w-full">
                                    <input type="checkbox" onclick="document.querySelectorAll('.rt24-checkbox').forEach(cb => cb.checked = this.checked)" class="rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer">
                                    <span>PILIH SEMUA</span>
                                </label>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($anggotaRT24 as $anggota)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-bold {{ $anggota->status == 'Sekolah' ? 'text-sky-600' : 'text-slate-800' }}">
                                {{ $anggota->nama }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-medium {{ $anggota->status == 'Sekolah' ? 'bg-sky-50 text-sky-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ $anggota->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center text-slate-600 font-semibold text-sm">
                                Rp {{ $anggota->status == 'Sekolah' ? '8.000' : '10.000' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <select name="kelipatan[{{ $anggota->id }}]" class="text-xs font-bold rounded-lg border-slate-200 py-1 px-2 focus:ring-red-500 focus:border-red-500 cursor-pointer">
                                    <option value="1">1x (Normal)</option>
                                    <option value="2">2x (Double)</option>
                                    <option value="3">3x (Triple)</option>
                                </select>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" name="anggota_ids[]" value="{{ $anggota->id }}" class="rt24-checkbox rounded border-slate-300 text-red-600 focus:ring-red-500 w-4 h-4 cursor-pointer">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- TOMBOL SUBMIT -->
            <div class="mt-8 bg-slate-50 border border-slate-200 rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center shadow-sm">
    
            <!-- TAMPILAN HITUNGAN REAL-TIME -->
            <div class="flex flex-wrap items-center gap-4 md:gap-8 mb-6 md:mb-0">
                <div>
                    <span class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">Arisan</span>
                    <span class="text-sm font-bold text-slate-700" id="teks-arisan">Rp 0</span>
                </div>
                <div>
                    <span class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">Tabungan</span>
                    <span class="text-sm font-bold text-slate-700" id="teks-tabungan">Rp 0</span>
                </div>
                <div>
                    <span class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">Dansos</span>
                    <span class="text-sm font-bold text-slate-700" id="teks-dansos">Rp 0</span>
                </div>
                <div class="pl-0 md:pl-6 border-l-0 md:border-l-2 border-slate-200">
                    <span class="block text-[10px] font-extrabold text-red-600 uppercase tracking-widest">Total Asok</span>
                    <span class="text-xl font-black text-red-600 tracking-tight" id="teks-total">Rp 0</span>
                </div>
            </div>
            
            <!-- TOMBOL SIMPAN -->
            <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                Simpan Ke Database
            </button>
        </div>

        <!-- SCRIPT PENGHITUNG OTOMATIS (MENDETEKSI KELIPATAN) -->
        <script>
            function hitungTotalIuran() {
                let totalArisan = 0;
                let totalTabungan = 0;
                let totalDansos = 0;

                // Cek semua baris di dalam tabel
                document.querySelectorAll('tbody tr').forEach(row => {
                    const checkbox = row.querySelector('input[type="checkbox"][name="anggota_ids[]"]');
                    const selectKelipatan = row.querySelector('select[name^="kelipatan"]');
                    const kolomStatus = row.querySelector('td:nth-child(2)'); // Kolom ke-2 adalah Status (Kerja/Sekolah)
                    
                    // Jika checkbox dicentang, mulai hitung!
                    if (checkbox && checkbox.checked && selectKelipatan && kolomStatus) {
                        const kelipatan = parseInt(selectKelipatan.value) || 1;
                        const statusAnggota = kolomStatus.innerText.trim().toUpperCase(); // Deteksi Kerja/Sekolah
                        
                        totalArisan += (5000 * kelipatan);
                        totalTabungan += (3000 * kelipatan);
                        
                        // Dansos hanya untuk yang Kerja (Rp 2.000)
                        if (statusAnggota === 'KERJA') {
                            totalDansos += (2000 * kelipatan);
                        }
                    }
                });

                const totalAsok = totalArisan + totalTabungan + totalDansos;

                // Fungsi format angka ke Rupiah
                const formatRp = (angka) => 'Rp ' + angka.toLocaleString('id-ID');

                // Tampilkan ke layar
                document.getElementById('teks-arisan').innerText = formatRp(totalArisan);
                document.getElementById('teks-tabungan').innerText = formatRp(totalTabungan);
                document.getElementById('teks-dansos').innerText = formatRp(totalDansos);
                document.getElementById('teks-total').innerText = formatRp(totalAsok);
            }

            // Jalankan hitungTotalIuran setiap kali ada kotak yang dicentang atau kelipatan diubah
            document.addEventListener('change', function(e) {
                if (e.target.tagName.toLowerCase() === 'input' || e.target.tagName.toLowerCase() === 'select') {
                    hitungTotalIuran();
                }
            });
        </script>
        </form>
        </div>

        </div>
    </div>


@endif
<script>
    document.getElementById('tombol-notif')?.addEventListener('click', function() {
        if (!("Notification" in window)) {
            alert("Browser HP Anda tidak mendukung Web Push Notification.");
            return;
        }
        Notification.requestPermission().then(function(izin) {
            if (izin === 'granted') {
                alert('Mantap! Anda akan menerima pengingat kumpulan di HP ini.');
            } else {
                alert('Izin ditolak. Anda tetap bisa melihat jadwal di halaman Beranda.');
        }
    });
</script>
</x-app-layout>