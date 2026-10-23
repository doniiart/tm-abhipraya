<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="text-center mb-10">
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-3">Galeri & Kegiatan<br>Terbaru</h1>
                <p class="text-sm text-slate-500 max-w-md mx-auto">Pilih kategori di bawah untuk melihat dokumentasi kegiatan Karang Taruna.</p>
                
                <!-- Filter Kategori (Desain Statis untuk Tampilan) -->
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <button type="button" class="px-5 py-2 bg-slate-900 text-white text-xs font-bold rounded-full shadow-md focus:outline-none transition-all select-none">Semua</button>
                    <button type="button" class="px-5 py-2 bg-white text-slate-600 text-xs font-bold rounded-full border border-slate-200 hover:bg-slate-50 hover:text-slate-900 active:bg-slate-100 active:text-slate-900 focus:outline-none focus:text-slate-900 transition-all select-none">Kumpulan Rutin</button>
                    <button type="button" class="px-5 py-2 bg-white text-slate-600 text-xs font-bold rounded-full border border-slate-200 hover:bg-slate-50 hover:text-slate-900 active:bg-slate-100 active:text-slate-900 focus:outline-none focus:text-slate-900 transition-all select-none">Bakti Sosial</button>
                    <button type="button" class="px-5 py-2 bg-white text-slate-600 text-xs font-bold rounded-full border border-slate-200 hover:bg-slate-50 hover:text-slate-900 active:bg-slate-100 active:text-slate-900 focus:outline-none focus:text-slate-900 transition-all select-none">Kepemudaan</button>
                </div>
            </div>

            <!-- Grid Galeri Dinamis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @forelse($kegiatans as $item)
                <!-- Kartu Item Kegiatan -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                    <!-- Foto -->
                    <div class="aspect-video w-full overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <!-- Konten Teks -->
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3">
                            {{ $item->kategori ?? 'Bakti Sosial' }}
                        </span>
                        <h2 class="text-lg font-bold text-slate-900 mb-2 leading-tight">{{ $item->judul }}</h2>
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                </div>
                @empty
                <!-- Tampilan jika database masih kosong -->
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-500">Belum ada kegiatan yang diunggah.</p>
                </div>
                @endforelse

            </div>
            
            <!-- Tombol Kembali -->
            <div class="mt-10 text-center">
                <a href="{{ url('/') }}" class="inline-block px-6 py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm">
                    &larr; Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</x-app-layout>