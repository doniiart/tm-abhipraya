<x-app-layout>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Manajemen Galeri Kegiatan</h2>
    </div>

    <!-- Alert Notifikasi Berhasil -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Form Tambah Foto -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-extrabold text-slate-900">Tambah Foto Baru</h2>
                    
                    <!-- Tombol Kembali ke Dashboard -->
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                        ← Kembali
                    </a>
                </div>                
                
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Kegiatan</label>
                        <input type="text" name="judul" required placeholder="Contoh: Kegiatan rutin pemuda" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50">
                            <option value="kumpulan">Kumpulan Rutin</option>
                            <option value="sosial">Bakti Sosial</option>
                            <option value="pemuda">Kepemudaan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" required placeholder="Ceritakan sedikit tentang kegiatan ini..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Unggah Foto</label>
                        <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" required class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-gray-900 file:text-white hover:file:bg-gray-800">
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 px-4 rounded-xl hover:bg-gray-800 hover:-translate-y-1 transition-all duration-300 shadow-md">
                        Simpan & Unggah Foto
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Daftar Foto Galeri -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-black text-gray-900 mb-4 border-b border-gray-100 pb-3">Galeri Tersimpan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($galeris as $item)
                        <div class="border border-gray-100 rounded-2xl overflow-hidden flex flex-col shadow-sm hover:shadow-md transition-shadow group">
                            <!-- Foto -->
                            <div class="h-48 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                
                                <!-- Label Kategori -->
                                <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-lg bg-white shadow-sm
                                    {{ $item->kategori == 'kumpulan' ? 'text-red-600' : ($item->kategori == 'sosial' ? 'text-blue-600' : 'text-yellow-600') }}">
                                    {{ $item->kategori == 'kumpulan' ? 'Kumpulan Rutin' : ($item->kategori == 'sosial' ? 'Bakti Sosial' : 'Kepemudaan') }}
                                </span>
                            </div>
                            
                            <!-- Konten Teks -->
                            <div class="p-5 flex-1 flex flex-col bg-white z-10 relative">
                                <h4 class="font-black text-lg text-gray-900 mb-2 leading-tight">{{ $item->judul }}</h4>
                                <p class="text-sm text-gray-500 mb-4 flex-1 leading-relaxed">{{ Str::limit($item->deskripsi, 80) }}</p>
                                
                                <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ substr($item->user->name ?? 'A', 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-gray-400">{{ $item->user->name ?? 'Admin' }}</span>
                                    </div>
                                    
                                    <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto {{ $item->judul }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg text-xs font-bold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center py-16 text-gray-400">
                            <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="font-medium text-gray-500">Belum ada foto yang diunggah.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>