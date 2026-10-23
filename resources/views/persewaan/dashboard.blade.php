<!-- Grid Menu Persewaan -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
    
    <!-- Menu 1: Daftar Aset Bolo Pecah -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-lg font-black text-slate-800 tracking-tight mb-1">Daftar Aset</h3>
        <p class="text-xs text-slate-500 font-medium mb-4">Kelola inventaris Bolo Pecah Sinoman & status ketersediaan.</p>
        <a href="{{ route('aset.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Cek Barang &rarr;</a>
    </div>

    <!-- Menu 2: Catatan Penyewa -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-black text-slate-800 tracking-tight mb-1">Data Sewa</h3>
        <p class="text-xs text-slate-500 font-medium mb-4">Catat nama, tanggal, item sewa, dan integrasi ke Kas Muda.</p>
        <a href="{{ route('sewa.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Input Sewa Baru &rarr;</a>
    </div>

    <!-- Menu 3: Penggantian & Nota -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative">
        <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h3 class="text-lg font-black text-slate-800 tracking-tight mb-1">Beli / Ganti Baru</h3>
        <p class="text-xs text-slate-500 font-medium mb-4">Laporan ganti barang rusak dan upload foto nota pembelian.</p>
        <a href="#" class="text-xs font-bold text-orange-600 hover:text-orange-700">Upload Nota &rarr;</a>
    </div>

</div>
