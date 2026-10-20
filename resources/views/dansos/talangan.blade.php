<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>

        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Input Talangan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm mb-6">
            <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                Input Dana Talangan (Ambil Tabungan)
            </h3>

            <form action="{{ route('dansos.talangan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Keterangan / Tujuan Talangan</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Tambahan untuk jenguk Mbah Warno" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nominal (Rp)</label>
                        <input type="number" name="nominal" placeholder="50000" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" required>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm shadow-md transition-all">
                    Simpan Dana Talangan
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Talangan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <h4 class="text-sm font-bold text-slate-800 mb-4">Daftar Riwayat Talangan</h4>

            <div class="space-y-3">
                @forelse($talangans as $item)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">
                                {{ $item->keterangan }}
                            </span>
                            <span class="text-[10px] text-slate-400">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-lg">
                                + Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </span>
                            <form action="{{ route('dansos.talangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data talangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-xs text-slate-400 py-4">Belum ada riwayat dana talangan.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>