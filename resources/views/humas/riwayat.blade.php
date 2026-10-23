<x-app-layout>
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">Riwayat Arisan</h2>
                <p class="text-sm text-slate-500 mt-1">Rekap pendapatan kas setiap kali kumpulan</p>
            </div>
            
            <a href="{{ url('/laporan/humas') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="py-4 px-2 text-[10px] font-extrabold text-slate-400 uppercase w-12 text-center">No</th>
                                <th class="py-4 px-2 text-[10px] font-extrabold text-slate-400 uppercase">Tanggal</th>
                                <th class="py-4 px-2 text-[10px] font-extrabold text-slate-400 uppercase text-center">Tempat Arisan</th>
                                <th class="py-4 px-2 text-[10px] font-extrabold text-slate-400 uppercase text-right">Mendapat Segini (Total)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/80">
                            @forelse($riwayat as $index => $item)
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors" x-data="{ showModal: false }">
                                    <td class="py-4 px-2 text-center text-xs font-semibold text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    
                                    <td class="py-4 px-2 font-bold text-slate-800 text-sm">
                                        <!-- Format tanggal menjadi rapi -->
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    
                                    <!-- Sementara ditulis statis/otomatis, jika belum ada input tempat di database Iuran -->
                                    <td class="py-4 px-2 text-center">
                                        <span class="text-xs font-bold text-slate-700 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                                            📍 {{ $item->tempat ?? 'Belum ditentukan' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Menampilkan Total Pendapatan Hari Itu -->
                                    <td class="py-4 px-6 text-right relative">
                                        <!-- Teks Total & Tombol Rincian -->
                                        <div class="font-bold text-emerald-600">
                                            Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                                        </div>
                                        <!-- Teks abu-abu transparan yang bisa diklik -->
                                        <button @click="showModal = true" type="button" class="text-[11px] text-slate-400 hover:text-slate-700 transition-colors mt-1 underline cursor-pointer">
                                            Lihat Rincian
                                        </button>

                                        <!-- KOTAK MODAL (POP-UP) BLUR -->
                                        <template x-teleport="body">
                                            <div x-show="showModal" 
                                                style="display: none;"
                                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity"
                                                x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0">
                                                
                                                <!-- Isi Kotak Putih di Tengah -->
                                                <div @click.outside="showModal = false" class="bg-white w-full max-w-3xl max-h-[85vh] overflow-y-auto rounded-3xl shadow-2xl p-6 sm:p-8 m-4 relative transform transition-all"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                                    
                                                    <!-- Header Modal (Judul & Tombol Silang) -->
                                                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                                                        <div>
                                                            <h3 class="text-xl font-extrabold text-slate-800">Rincian Iuran Anggota</h3>
                                                            <p class="text-sm text-slate-500 mt-1">Tanggal Kumpulan: {{ $item->tanggal }}</p>
                                                        </div>
                                                        <button @click="showModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-red-100 hover:text-red-600 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>

                                                    <!-- Tabel Rincian Anggota -->
                                                    <div class="overflow-x-auto">
                                                        <table class="w-full text-left text-sm">
                                                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                                                <tr>
                                                                    <th class="py-3 px-4 rounded-tl-xl">Nama Pemuda</th>
                                                                    <th class="py-3 px-4">Arisan</th>
                                                                    <th class="py-3 px-4">Tabungan</th>
                                                                    <th class="py-3 px-4 rounded-tr-xl">Dansos</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100">
                                                                @php
                                                                    // Mengambil data iuran asli dari database berdasarkan tanggal baris ini
                                                                    $dataRincian = \App\Models\Iuran::with('anggota')
                                                                                    ->where('tanggal', $item->tanggal)
                                                                                    ->get();
                                                                @endphp

                                                                @forelse($dataRincian as $detail)
                                                                    <tr class="hover:bg-slate-50">
                                                                        <td class="py-3 px-4 font-bold text-slate-700">
                                                                            {{ $detail->anggota->nama ?? 'Nama tidak ditemukan' }}
                                                                        </td>
                                                                        <td class="py-3 px-4 text-slate-700">
                                                                            Rp {{ number_format($detail->arisan, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="py-3 px-4 text-slate-700">
                                                                            Rp {{ number_format($detail->tabungan, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="py-3 px-4 text-slate-700">
                                                                            Rp {{ number_format($detail->dansos, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="py-4 px-4 text-center text-slate-500 italic">
                                                                            Tidak ada data rincian yang ditemukan.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-500 text-sm font-medium">
                                        Belum ada riwayat kumpulan arisan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>