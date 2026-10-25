<x-app-layout>
    <div class="py-8 px-4 max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Buku Pengeluaran</h2>
                <p class="text-sm text-slate-500">Rincian catatan uang keluar Bendahara.</p>
            </div>
            <!-- Sesuaikan route('bendahara.dashboard') dengan nama rute dashboard Anda -->
            <a href="{{ url()->previous() }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">&larr; Kembali</a>
        </div>

        <!-- Daftar Pengeluaran -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="space-y-3">
                @forelse($pengeluarans as $item)
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-4 bg-slate-50 rounded-xl border border-slate-100 gap-2">
                        <div>
                            <p class="font-bold text-slate-700">{{ $item->keperluan }}</p>
                            <p class="text-xs text-slate-400 mt-1 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <span class="font-black text-red-500 bg-red-50 px-3 py-1.5 rounded-lg">-Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm font-bold text-slate-400">Belum ada catatan pengeluaran.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
    </div>
</x-app-layout>