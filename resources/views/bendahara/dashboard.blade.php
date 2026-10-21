<!-- Grid 4 Kartu Kas Bendahara -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- 1. Kartu Tabungan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-emerald-50 text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TABUNGAN</span>
        </div>
        <p class="text-xs text-slate-500 font-medium mb-1">Total Saldo Terkumpul</p>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h3>
        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="{{ route('bendahara.tabungan') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center transition-colors">
                Rincian Tabungan &rarr;
            </a>
        </div>
    </div>

    <!-- 2. Kartu Kas Muda -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS MUDA</span>
        </div>
        <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp 0</h3>
        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center transition-colors">
                Kelola Kas Muda &rarr;
            </a>
        </div>
    </div>

    <!-- 3. Kartu Kas Tua -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-indigo-50 text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAS TUA</span>
        </div>
        <p class="text-xs text-slate-500 font-medium mb-1">Saldo Persewaan</p>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp 0</h3>
        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center transition-colors">
                Kelola Kas Tua &rarr;
            </a>
        </div>
    </div>

    <!-- 4. Kartu Kompensasi -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-orange-50 text-orange-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KOMPENSASI</span>
        </div>
        <p class="text-xs text-slate-500 font-medium mb-1">Dana Pemasukan Luar</p>
        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp 0</h3>
        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="#" class="text-xs font-bold text-orange-600 hover:text-orange-700 inline-flex items-center transition-colors">
                Cek Riwayat &rarr;
            </a>
        </div>
    </div>

</div>