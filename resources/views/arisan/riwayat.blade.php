<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800">Buku Riwayat Arisan</h2>
                    <p class="text-sm text-slate-500">Rincian lengkap perhitungan laporan arisan bulan-bulan sebelumnya.</p>
                </div>
                <a href="{{ url('/') }}#bagian-laporan" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    &larr; Kembali ke Menu Utama
                </a>
            </div>

            <!-- Daftar Riwayat -->
            <div class="space-y-4">
                @forelse($riwayats as $item)
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                        
                        <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-4 border-b border-slate-100 pb-4 gap-4">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </p>
                                <h3 class="text-lg font-black text-slate-800">
                                    Tempat: {{ $item->tempat }}
                                </h3>
                            </div>
                            <div class="sm:text-right bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-100">
                                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Arisan Cair (Bersih)</p>
                                <p class="text-xl font-black text-emerald-600">Rp {{ number_format($item->arisan_mendapatkan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-slate-400 text-[11px] font-bold uppercase mb-1">Total Pemasukan</p>
                                <p class="font-black text-slate-700">Rp {{ number_format($item->total_kas_awal, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-[11px] font-bold uppercase mb-1">Potongan Dansos</p>
                                <p class="font-black text-red-500">- Rp {{ number_format($item->potongan_dansos, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-[11px] font-bold uppercase mb-1">Tutup Defisit Lalu</p>
                                <p class="font-black text-amber-500">- Rp {{ number_format($item->tutup_defisit_lalu, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-red-50 p-2 rounded-lg border border-red-100">
                                <p class="text-red-400 text-[11px] font-bold uppercase mb-1">Masih Kurang</p>
                                <p class="font-black text-red-600">Rp {{ number_format($item->masih_kurang, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Belum ada riwayat laporan arisan yang tersimpan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>