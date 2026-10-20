<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs">
                
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Buat & Kirim Notifikasi Push</h2>
                        <p class="text-xs text-slate-500 mt-1">Pengumuman akan dikirim langsung ke seluruh perangkat pemuda terpilih.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-xs text-slate-600 hover:text-slate-900 font-semibold border border-slate-200 px-3 py-1.5 rounded-lg">
                        ← Kembali
                    </a>
                </div>

                @if(session('error'))
                    <div class="mb-4 p-4 text-xs text-red-800 rounded-xl bg-red-50 border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('pengumuman.send') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Target RT -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Target Penerima</label>
                        <select name="target_rt" class="w-full text-sm border-slate-300 rounded-xl focus:ring-slate-900 focus:border-slate-900">
                            @if(Auth::user()->rt_akses == 'all' || Auth::user()->rt_akses == '23')
                                <option value="23">Pemuda RT 23</option>
                            @endif
                            
                            @if(Auth::user()->rt_akses == 'all' || Auth::user()->rt_akses == '24')
                                <option value="24">Pemuda RT 24</option>
                            @endif

                            @if(Auth::user()->rt_akses == 'all')
                                <option value="all">Semua Pemuda (RT 23 & 24)</option>
                            @endif
                        </select>
                    </div>

                    <!-- Judul Notifikasi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman</label>
                        <input type="text" name="judul" required placeholder="Contoh: Jangan lupa nanti malam kumpulan tunas remaja" class="w-full text-sm border-slate-300 rounded-xl focus:ring-slate-900 focus:border-slate-900">
                    </div>

                    <!-- Isi Pesan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Pesan Notifikasi</label>
                        <textarea name="isi" rows="4" required placeholder="Tuliskan detail pengumuman di sini..." class="w-full text-sm border-slate-300 rounded-xl focus:ring-slate-900 focus:border-slate-900"></textarea>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-md">
                            Kirim Push Notification Sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>