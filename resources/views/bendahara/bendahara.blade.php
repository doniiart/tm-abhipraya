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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Kartu Tabungan -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-emerald-50 text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TABUNGAN</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mb-1">Total Saldo Terkumpul</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h3>
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
                    <p class="text-xs text-slate-500 font-medium mb-1">Dana Pemasukan Luar</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalKompensasi, 0, ',', '.') }}</h3>
                </div>

            </div>
            
            

        </div>
    </div>
</x-app-layout>