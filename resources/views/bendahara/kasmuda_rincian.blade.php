<x-app-layout>
    <div class="py-8 px-4 max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Rincian Kas Muda</h2>
                <p class="text-sm text-slate-500">Kelola dan catat uang masuk Kas Muda.</p>
            </div>
            <a href="{{ url()->previous() }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">&larr; Kembali</a>
        </div>

        <!-- Tombol Tambah & Daftar Riwayat -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="bukaModalKasMuda()" class="mb-6 w-full text-center text-sm font-bold text-blue-600 bg-blue-50 py-3 rounded-xl border border-blue-100 hover:bg-blue-100 transition-colors">
                + Catat Pemasukan Kas Muda
            </button>

            <div class="space-y-3">
                @forelse($kasMudas as $item)
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</span>
                        <span class="font-black text-blue-500 bg-blue-50 px-3 py-1.5 rounded-lg">+Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-center py-8 text-sm font-bold text-slate-400">Belum ada catatan kas.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MODAL POP-UP (Pindahan dari Dashboard) -->
    <div id="modalKasMuda" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="tutupModalKasMuda()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
                <form action="{{ route('bendahara.kasmuda.store') }}" method="POST">
                    @csrf
                    <div class="p-8">
                        <h3 class="text-xl font-black text-slate-800 mb-6 text-center">Catat Kas Muda</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" required class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Nominal (Rp)</label>
                                <input type="number" name="nominal" required class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">
                        <button type="button" onclick="tutupModalKasMuda()" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function bukaModalKasMuda() { document.getElementById('modalKasMuda').classList.remove('hidden'); }
        function tutupModalKasMuda() { document.getElementById('modalKasMuda').classList.add('hidden'); }
    </script>
</x-app-layout>