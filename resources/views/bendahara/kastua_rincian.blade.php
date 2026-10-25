<x-app-layout>
    <div class="py-8 px-4 max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Rincian Kas Tua</h2>
                <p class="text-sm text-slate-500">Kelola dan catat uang masuk Kas Tua.</p>
            </div>
            <a href="{{ url()->previous() }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">&larr; Kembali</a>
        </div>

        <!-- Tombol Tambah & Daftar Riwayat -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="bukaModalkasTua()" class="mb-6 w-full text-center text-sm font-bold text-purple-600 bg-purple-50 py-3 rounded-xl border border-purple-100 hover:bg-purple-100 transition-colors">
                + Catat Pemasukan Kas Tua
            </button>

            <div class="space-y-3">
                @forelse($kasTuas as $item)
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</span>
                        <span class="font-black text-purple-500 bg-purple-50 px-3 py-1.5 rounded-lg">+Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-center py-8 text-sm font-bold text-slate-400">Belum ada catatan kas.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MODAL POP-UP (Pindahan dari Dashboard) -->
    <div id="modalkasTua" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="tutupModalkasTua()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
                <form action="{{ route('bendahara.kastua.store') }}" method="POST">
                    @csrf
                    <div class="p-8">
                        <h3 class="text-xl font-black text-slate-800 mb-6 text-center">Catat Kas Tua</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" required class="w-full rounded-xl border-slate-200 focus:border-purple-500 focus:ring focus:ring-purple-200">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Nominal (Rp)</label>
                                <input type="number" name="nominal" required class="w-full rounded-xl border-slate-200 focus:border-purple-500 focus:ring focus:ring-purple-200">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">
                        <button type="button" onclick="tutupModalkasTua()" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-purple-600 rounded-xl hover:bg-purple-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function bukaModalkasTua() { document.getElementById('modalkasTua').classList.remove('hidden'); }
        function tutupModalkasTua() { document.getElementById('modalkasTua').classList.add('hidden'); }
    </script>
</x-app-layout>