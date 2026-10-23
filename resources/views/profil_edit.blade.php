<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 sm:p-10 border-b border-slate-100 bg-slate-900 text-white">
                    <h2 class="text-2xl font-black tracking-tight">Edit Profil Organisasi</h2>
                    <p class="text-sm text-slate-400 mt-1">Perbarui informasi, deskripsi, dan sejarah Karang Taruna.</p>
                </div>

                <form action="{{ url('/profil/update') }}" method="POST" class="p-6 sm:p-10">
                    @csrf
                    
                    <!-- Input Nama Organisasi -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi" value="{{ $settings->nama_organisasi ?? '' }}" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 shadow-sm" required>
                    </div>

                    <!-- Input Deskripsi -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="4" class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 shadow-sm" required>{{ $settings->deskripsi ?? '' }}</textarea>
                    </div>

                    <!-- Input Tahun Berdiri -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Berdiri</label>
                        <input type="number" name="tahun_berdiri" value="{{ $settings->tahun_berdiri ?? '' }}" class="w-full sm:w-1/3 rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 shadow-sm" required>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-md hover:bg-red-700 hover:shadow-lg transition-all">Simpan Perubahan</button>
                        <a href="{{ url('/profil') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>