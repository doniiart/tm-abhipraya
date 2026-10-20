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
                                <tr class="hover:bg-slate-50/50 transition-colors">
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
                                    <td class="py-4 px-2 text-right font-extrabold text-emerald-600 text-base">
                                        Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
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