<x-app-layout>
    <div class="py-8 px-4 max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-black text-slate-800">Laporan Arisan</h2>
            <a href="{{ url()->previous() }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">&larr; Kembali</a>
        </div>

        <!-- Tampilan Rincian (Tanpa Form Edit) -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Rincian Pembagian Bulan Ini</h3>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-sm font-bold text-slate-600">Total Uang Masuk</span>
                    <span class="font-black text-slate-700">Rp {{ number_format($totalHumas, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-xl border border-red-100">
                    <span class="text-sm font-bold text-red-500">Potongan Dansos</span>
                    <span class="font-black text-red-600">- Rp {{ number_format($potonganDansos, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-amber-50 rounded-xl border border-amber-100">
                    <span class="text-sm font-bold text-amber-600">Tutup Defisit Bln Lalu</span>
                    <span class="font-black text-amber-600">- Rp {{ number_format($kekuranganBulanKemarin, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Arisan Cair -->
            <div class="text-center bg-emerald-50 py-6 rounded-2xl border border-emerald-100 mb-4">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Arisan Mendapatkan (Bersih)</p>
                <p class="text-4xl font-black text-emerald-600">Rp {{ number_format($arisanMendapatkan, 0, ',', '.') }}</p>
            </div>

            <!-- Status Kekurangan -->
            <div class="flex justify-between items-center p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-sm font-bold text-slate-500">Status Target (Rp {{ number_format($targetHakTuanRumah, 0, ',', '.') }})</span>
                
                <span class="font-black {{ $totalHumas == 0 ? 'text-slate-400' : ($masihKurangBulanIni > 0 ? 'text-red-500' : 'text-emerald-500') }}">
                    @if($totalHumas == 0)
                        Menunggu Iuran
                    @elseif($masihKurangBulanIni > 0)
                        Masih Kurang Rp {{ number_format($masihKurangBulanIni, 0, ',', '.') }}
                    @else
                        Tercapai
                    @endif
                </span>
            </div>
        </div>

        <!-- Tombol Ke Buku Riwayat -->
        <div class="mt-6 text-center">
            <a href="{{ route('arisan.riwayat') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-500 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Lihat Buku Riwayat Bulan Sebelumnya
            </a>
        </div>
        
    </div>
</x-app-layout>