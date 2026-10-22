<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Transparansi Organisasi</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Laporan Resmi Humas</h1>
                    <p class="text-sm text-slate-500 mt-1">Rekapitulasi iuran dan kas pemuda Tunas Muda Abhipraya Candi Rejo & Gunung Rejo</p>
                </div>
                <!-- Tombol Kembali ke Dashboard Utama (Beranda) -->
            <a href="{{ url('/') }}#bagian-laporan" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    &larr; Kembali ke Menu Utama
                </a>
            </div>

            <!-- Ringkasan Kartu Total -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kas Masuk Humas Candi</span>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Rp {{ number_format($totalRT23, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-2">Akumulasi dari setoran Arisan, Tabungan, dan Dansos pemuda Candi.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kas Masuk Humas Gunung</span>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Rp {{ number_format($totalRT24, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-2">Akumulasi dari setoran Arisan, Tabungan, dan Dansos pemuda Gunung.</p>
                </div>
            </div>

            <a href="{{ url('laporan/humas/riwayat') }}" class="group block w-full bg-white rounded-[1.5rem] border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-red-200 transition-all duration-300 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Ikon Buku/Catatan -->
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 group-hover:text-red-600 transition-colors">Lihat Riwayat Arisan Lengkap</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Rekapitulasi total pendapatan per kumpulan</p>
                        </div>
                    </div>
                    
                    <!-- Panah Kanan -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-red-500 group-hover:translate-x-1 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Tabel Detail Per RT (Menggunakan Alpine.js Tab) -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-2xs" x-data="{ activeTab: 'rt23' }">
                <div class="flex justify-between items-center pb-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900">Rincian Riwayat Setoran</h2>
                    
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl space-x-1">
                        <button @click="activeTab = 'rt23'" 
                                :class="{ 'bg-white text-slate-900 shadow-xs font-semibold': activeTab === 'rt23', 'text-slate-600 hover:text-slate-900 font-medium': activeTab !== 'rt23' }" 
                                class="px-4 py-2 rounded-lg text-xs transition-all">
                            RT 23
                        </button>
                        <button @click="activeTab = 'rt24'"
                                :class="{ 'bg-white text-slate-900 shadow-xs font-semibold': activeTab === 'rt24', 'text-slate-600 hover:text-slate-900 font-medium': activeTab !== 'rt24' }" 
                                class="px-4 py-2 rounded-lg text-xs transition-all">
                            RT 24
                        </button>
                    </div>
                </div>

                <!-- Tabel RT 23 -->
                <div x-show="activeTab === 'rt23'" class="mt-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <!-- Tambahkan background amber/orange pada bagian thead ini -->
                        <thead class="bg-gradient-to-r from-orange-100 to-amber-50 border-y border-orange-100">
                            <tr>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Nama Pemuda
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Arisan
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Tabungan
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Dansos
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @forelse($iuranRT23 as $item)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 text-slate-500 text-xs">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4 font-medium text-slate-800">{{ $item->anggota->nama ?? '-' }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->arisan, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->tabungan, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->dansos, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada data riwayat iuran untuk RT 23.</td>
                            </tr>
                            @endforelse

                            <!-- Baris Total -->
                            <tr class="bg-slate-50 font-bold border-t-2 border-slate-200">
                                <td colspan="2" class="py-4 px-6 text-right text-xs uppercase tracking-wider text-slate-600">
                                    Total Keseluruhan
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    Rp {{ number_format($iuranRT23->sum('arisan'), 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    Rp {{ number_format($iuranRT23->sum('tabungan'), 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    Rp {{ number_format($iuranRT23->sum('dansos'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                <!-- Tabel RT 24 -->
                <div x-show="activeTab === 'rt24'" class="mt-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-orange-100 to-amber-50 border-y border-orange-100">
                            <tr>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Nama Pemuda
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Arisan
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Tabungan
                                </th>
                                <th scope="col" class="py-4 px-6 text-left text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                                    Dansos
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @forelse($iuranRT24 as $item)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 text-slate-500 text-xs">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4 font-medium text-slate-800">{{ $item->anggota->nama ?? '-' }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->arisan, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->tabungan, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-slate-600">Rp {{ number_format($item->dansos, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada data riwayat iuran untuk RT 24.</td>
                            </tr>
                            @endforelse

                            <tr class="bg-slate-50 font-bold border-t-2 border-slate-200">
                                <td colspan="2" class="py-4 px-6 text-right text-xs uppercase tracking-wider text-slate-600">
                                    Total Keseluruhan
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    <!-- Ubah $riwayats dengan nama variabel yang Mas Doni pakai di perulangan foreach -->
                                    Rp {{ number_format($iuranRT24->sum('arisan'), 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    Rp {{ number_format($iuranRT24->sum('tabungan'), 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-800">
                                    Rp {{ number_format($iuranRT24->sum('dansos'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>