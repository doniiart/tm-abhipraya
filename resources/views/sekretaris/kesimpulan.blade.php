<x-app-layout><!-- Navbar / Header -->
    <div class="bg-white border-b border-slate-200 px-6 py-4 shadow-sm mb-8">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-purple-700 tracking-tight">Buku Induk Sekretaris</h1>
                <p class="text-sm text-slate-500 font-medium">Riwayat Kesimpulan Pertemuan</p>
            </div>
            <a href="{{ route('laporan.sekretaris.publik') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2 px-4 rounded-xl transition-colors text-sm">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        
        <h2 class="text-xl font-bold text-slate-800 mb-6 border-l-4 border-purple-600 pl-3">Daftar Rekap Kesimpulan</h2>

        @if($rekapData->isEmpty())
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200 shadow-sm">
                <p class="text-slate-500">Belum ada riwayat kesimpulan pertemuan yang disimpan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($rekapData as $rekap)
                <!-- Kartu Rekap -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <!-- Header Kartu (Warna Gradasi) -->
                    <div style="background: linear-gradient(to right, #7e22ce, #4338ca);" class="px-6 py-4 text-white flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $rekap->agenda_lokasi }}</h3>
                            <p class="text-xs text-purple-200">{{ $rekap->agenda_nama }} &bull; {{ $rekap->agenda_tanggal }}</p>
                        </div>
                        <div class="text-xs bg-white/20 px-3 py-1 rounded-full font-semibold">
                            Tutup Buku
                        </div>
                    </div>
                    
                    <!-- Isi Data Keuangan & Notulensi -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Rincian Keuangan -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-3 border-b pb-2">Rincian Keuangan</h4>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Pihak Candi:</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($rekap->total_candi, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Pihak Gunung:</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($rekap->total_gunung, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-t border-dashed pt-2 mt-2">
                                    <span class="font-bold text-slate-600">Total Humas Masuk:</span>
                                    <span class="font-bold text-purple-600">Rp {{ number_format($rekap->total_candi + $rekap->total_gunung, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Total Arisan:</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($rekap->total_arisan, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-red-500">
                                    <span>Kepotong Dansos:</span>
                                    <span class="font-bold">- Rp {{ number_format($rekap->potongan_dansos, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-t border-dashed pt-2 mt-2">
                                    <span class="font-bold text-slate-600">Arisan Bersih Didapat:</span>
                                    <span class="font-bold text-green-600">Rp {{ number_format($rekap->total_arisan - $rekap->potongan_dansos, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Notulensi -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-3 border-b pb-2">Catatan & Usulan</h4>
                            <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 min-h-[120px] whitespace-pre-line border border-slate-100">
                                {{ $rekap->notulensi ? $rekap->notulensi : 'Tidak ada catatan.' }}
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endforeach
            </div>
        @endif
        
    </div>
</x-app-layout>