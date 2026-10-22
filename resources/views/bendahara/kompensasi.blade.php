<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Tombol Kembali -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold tracking-widest text-orange-500 uppercase">Dana Pemasukan Luar</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Kelola Kompensasi</h1>
                    <p class="text-sm text-slate-500 mt-1">Pencatatan dana masuk dari instansi, perusahaan, atau donatur luar.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Form Input (Kiri) -->
                <div class="lg:col-span-1">
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-2xs p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Input Dana Baru</h3>
                        
                        <form action="{{ route('bendahara.kompensasi.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Tanggal Masuk</label>
                                <input type="date" name="tanggal" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Sumber Dana / Keterangan</label>
                                <input type="text" name="sumber_dana" required placeholder="Contoh: Dana CSR PT ABC" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Nominal (Rp)</label>
                                <input type="number" name="nominal" required min="1" placeholder="Contoh: 500000" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            </div>

                            <button type="submit" class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-all shadow-[0_4px_12px_rgba(234,88,12,0.25)] hover:-translate-y-0.5 mt-2">
                                Simpan Data
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tabel Riwayat (Kanan) -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-2xs overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="text-lg font-bold text-slate-800">Riwayat Kompensasi</h3>
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">Total: Rp {{ number_format($riwayat->sum('nominal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-white border-b border-slate-100">
                                    <tr>
                                        <th class="py-3 px-6 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="py-3 px-6 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Sumber Dana</th>
                                        <th class="py-3 px-6 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-sm">
                                    @forelse($riwayat as $item)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="py-3 px-6 text-slate-500">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                            <td class="py-3 px-6 text-slate-800 font-medium">{{ $item->sumber_dana }}</td>
                                            <td class="py-3 px-6 text-orange-600 font-bold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center text-slate-400 text-sm">Belum ada data kompensasi yang tercatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>