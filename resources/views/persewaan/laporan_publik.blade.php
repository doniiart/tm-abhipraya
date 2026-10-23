<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="mb-8">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Transparansi Inventaris</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Laporan Persewaan</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar ketersediaan barang inventaris dan catatan peminjaman.</p>
                <div class="mt-6">
                    <a href="{{ url('/') }}#bagian-laporan" class="inline-flex items-center justify-center px-6 py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                        &larr; Kembali ke Menu Laporan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- BAGIAN 1: TABEL DAFTAR ASET (KETERSEDIAAN) -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            Daftar Nama Aset Karang Taruna
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                                <tr>
                                    <th class="py-3 px-4 w-12 text-center">NO</th>
                                    <th class="py-3 px-4">NAMA BARANG</th>
                                    <th class="py-3 px-4 text-center">JUMLAH</th>
                                    <th class="py-3 px-4 text-center">KONDISI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-xs sm:text-sm">
                                @forelse($asets as $index => $aset)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-4 text-center text-slate-400">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 font-bold text-slate-800">{{ $aset->nama_aset }}</td>
                                        <td class="py-3 px-4 text-center font-bold {{ $aset->jumlah == 0 ? 'text-red-500' : 'text-slate-700' }}">{{ $aset->jumlah }}</td>
                                        <td class="py-3 px-4 text-center">
                                            @if($aset->kondisi == 'Baik')
                                                <span class="text-emerald-600 font-semibold bg-emerald-50 px-2 py-1 rounded">Baik</span>
                                            @else
                                                <span class="text-amber-600 font-semibold bg-amber-50 px-2 py-1 rounded">{{ $aset->kondisi }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500">Belum ada data barang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BAGIAN 2: TABEL SEDANG DISEWA -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            Barang Sedang Disewa
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                                <tr>
                                    <th class="py-3 px-4">PENYEWA</th>
                                    <th class="py-3 px-4">BARANG</th>
                                    <th class="py-3 px-4 text-center">TGL SEWA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-xs sm:text-sm">
                                @forelse($sewas as $sewa)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <p class="font-bold text-slate-800">{{ $sewa->nama_penyewa }}</p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $sewa->alamat }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="font-bold text-blue-600">{{ $sewa->aset->nama_aset ?? '-' }}</p>
                                            <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $sewa->jumlah_pinjam }} unit</p>
                                        </td>
                                        <td class="py-3 px-4 text-center text-slate-600 font-medium">
                                            {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-slate-500 font-medium">
                                            Saat ini tidak ada barang yang disewa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>