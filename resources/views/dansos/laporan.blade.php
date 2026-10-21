<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resmi Dansos - Tunas Muda Abhipraya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 font-sans antialiased">
    {{-- Memanggil Navbar Atas --}}
    @include('layouts.navigation')
    <!-- Menggunakan max-w-7xl agar lebarnya sama dengan halaman Humas -->
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 pt-6">
        
        <!-- HEADER (Dibuat rata kiri & seragam dengan Humas) -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Transparansi Organisasi</p>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2">Laporan Resmi Dansos</h1>
                <p class="text-sm text-slate-500">Rekapitulasi pengeluaran menjenguk/takziah dan dana talangan Karang Taruna.</p>
            </div>
            
            <div class="mt-2 md:mt-0 flex-shrink-0">
                <!-- Tombol putih bergaris (outline) ala Humas -->
                <a href="{{ url('/') }}#bagian-laporan" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-full hover:bg-slate-50 transition-colors shadow-sm">
                    &larr; Kembali ke Dashboard Utama
                </a>
            </div>
        </div>

        <!-- GRID 2 KOLOM UNTUK DATA -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- KARTU DAFTAR PENGELUARAN -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header ber-background Merah Logo -->
            <div class="bg-gradient-to-r from-orange-100 to-amber-50 px-6 py-5 sm:px-8 border-b border-orange-100">
                <h2 class="text-base font-black tracking-wide text-slate-800 uppercase">Rincian Pengeluaran</h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Data penggunaan dana sosial untuk warga.</p>
            </div>
            
            <!-- Pembungkus jarak (padding) agar data tidak mepet pinggir layar -->
            <div class="px-6 pb-6 sm:px-8 sm:pb-8">
                <div class="space-y-0">
                    @forelse($pengeluaran as $item)
                        <div class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->keterangan ?? 'Menjenguk / Takziah' }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                            <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-center text-slate-400 py-8">Belum ada data pengeluaran dicatat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KARTU DAFTAR TALANGAN -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header ber-background Merah Logo -->
            <div class="bg-gradient-to-r from-orange-100 to-amber-50 px-6 py-5 sm:px-8 border-b border-orange-100">
                <h2 class="text-base font-black tracking-wide text-slate-800 uppercase">Rincian Talangan</h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Data kas yang digunakan untuk dana talangan kegiatan.</p>
            </div>
            
            <!-- Pembungkus jarak (padding) agar data tidak mepet pinggir layar -->
            <div class="px-6 pb-6 sm:px-8 sm:pb-8">
                <div class="space-y-0">
                    @forelse($talangan as $item)
                        <div class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->keterangan ?? 'Talangan Kegiatan' }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                            <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-center text-slate-400 py-8">Belum ada data talangan dicatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- KARTU 3: BULAN KEMARIN (TOTAL DANSOS + ARISAN) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <!-- Header ber-background Amber Lembut -->
                    <div class="bg-gradient-to-r from-orange-100 to-amber-50 px-6 py-5 sm:px-8 border-b border-orange-100">
                        <h2 class="text-base font-black tracking-wide text-slate-800 uppercase">Bulan Kemarin</h2>
                        <p class="text-xs font-medium text-slate-500 mt-1">Total Dansos + Arisan bulan sebelumnya.</p>
                    </div>
                    
                    <div class="px-6 pb-6 sm:px-8 sm:pb-8">
                        <div class="space-y-0">
                            <!-- Karena ini ringkasan, kita buat 1 baris statis (atau bisa Mas Doni ganti dengan variabel controller nantinya) -->
                            <div class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Total Akumulasi</p>
                                    <p class="text-xs text-slate-500 mt-1">Saldo Bulan Lalu</p>
                                </div>
                                <span class="text-sm font-bold text-slate-800">Rp {{ number_format($totalBulanKemarin, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU 4: BULAN INI (SETORAN KEDUA HUMAS) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <!-- Header ber-background Amber Lembut -->
                    <div class="bg-gradient-to-r from-orange-100 to-amber-50 px-6 py-5 sm:px-8 border-b border-orange-100">
                        <h2 class="text-base font-black tracking-wide text-slate-800 uppercase">Bulan Ini</h2>
                        <p class="text-xs font-medium text-slate-500 mt-1">Setoran kedua Humas Karang Taruna.</p>
                    </div>
                    
                    <div class="px-6 pb-6 sm:px-8 sm:pb-8">
                        <div class="space-y-0">
                            <div class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Setoran Humas</p>
                                    <p class="text-xs text-slate-500 mt-1">Bulan Sekarang</p>
                                </div>

                                <span class="text-sm font-bold text-emerald-600">+ Rp {{ number_format($setoranBulanIni, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</body>
</html>