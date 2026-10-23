<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ activeTab: 'rt23' }">
            
            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Manajemen Iuran Humas</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pencatatan iuran pemuda berdasarkan domisili RT.</p>
            </div>

            <!-- Navigasi Tab -->
            <div class="flex space-x-2 mb-4">
                <button @click="activeTab = 'rt23'" 
                        :class="{ 'bg-gray-900 text-white': activeTab === 'rt23', 'bg-white text-gray-600 border border-gray-200': activeTab !== 'rt23' }" 
                        class="px-5 py-2.5 rounded-xl font-bold shadow-sm transition-all duration-200 text-sm">
                    Pemuda RT 23
                </button>
                <button @click="activeTab = 'rt24'" 
                        :class="{ 'bg-gray-900 text-white': activeTab === 'rt24', 'bg-white text-gray-600 border border-gray-200': activeTab !== 'rt24' }" 
                        class="px-5 py-2.5 rounded-xl font-bold shadow-sm transition-all duration-200 text-sm">
                    Pemuda RT 24
                </button>
            </div>

            <!-- Form Simpan Iuran -->
            <form action="{{ route('humas.store') }}" method="POST">
                @csrf
                <!-- DROPDOWN PILIHAN AGENDA (Taruh di bawah @csrf) -->
                <div class="mb-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-extrabold text-slate-600 mb-1">PILIH SESI PERTEMUAN / AGENDA:</label>
                    <select name="meeting_id" class="w-full sm:w-1/2 rounded-xl border-slate-300 text-sm font-bold text-slate-800 focus:ring-red-500 focus:border-red-500">
                        @foreach($agendas as $agenda)
                            <option value="{{ $agenda->id }}">
                                {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d F Y') }} - {{ $agenda->lokasi }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 italic mt-1">*Pilih agenda bulan kemarin jika ingin menginput iuran susulan/double.</p>
                </div>

                <!-- Konten Tabel RT 23 -->
                <div x-show="activeTab === 'rt23'" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-500 font-bold">
                                <th class="py-4 px-6">Nama Pemuda</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center">Nominal Wajib</th>
                                <th class="py-4 px-6 text-center text-[10px] font-extrabold text-slate-400 uppercase">Kelipatan</th>
                                <th class="py-4 px-6 text-center">Asok Iuran?</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($anggotaRT23 as $anggota)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    
                                    <!-- 1. Kolom Nama -->
                                    <td class="py-4 px-6 font-extrabold {{ $anggota->status == 'Sekolah' ? 'text-blue-600' : 'text-slate-900' }}">
                                        {{ $anggota->nama }}
                                    </td>

                                    <!-- 2. Kolom Status -->
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $anggota->status == 'Sekolah' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ $anggota->status }}
                                        </span>
                                    </td>

                                    <!-- 3. Kolom Nominal Wajib -->
                                    <td class="py-4 px-6 text-center font-bold text-slate-700 text-sm">
                                        Rp {{ $anggota->status == 'Sekolah' ? '8.000' : '10.000' }}
                                    </td>

                                    <!-- 4. KOLOM KELIPATAN BAYAR -->
                                    <td class="py-3 px-4 text-center">
                                        @php
                                            // 1. Cari tanggal kumpulan yang paling terakhir tersimpan di sistem
                                            $tanggalTerakhir = \App\Models\Iuran::max('tanggal');
                                            
                                            // 2. Cek apakah anggota ini menyetor iuran di tanggal terakhir tersebut
                                            $cekIuran = \App\Models\Iuran::where('anggota_id', $anggota->id)
                                                                        ->where('tanggal', $tanggalTerakhir)
                                                                        ->first();
                                            
                                            // 3. Tentukan dia nunggak atau tidak (Tidak ada data ATAU total setorannya Rp 0)
                                            $nunggak = $tanggalTerakhir && (!$cekIuran || ($cekIuran->arisan + $cekIuran->tabungan + $cekIuran->dansos) == 0);
                                        @endphp

                                        @if($nunggak)
                                            <!-- Jika Nunggak: Otomatis pilih 2x dan beri warna merah sebagai pengingat -->
                                            <select name="kelipatan[{{ $anggota->id }}]" class="text-xs font-bold rounded-lg border-red-300 bg-red-50 text-red-700 py-1 px-2 focus:ring-red-500 focus:border-red-500 shadow-sm animate-pulse">
                                                <option value="1">1x</option>
                                                <option value="2" selected>2x (Nunggak)</option>
                                                <option value="3">3x</option>
                                            </select>
                                        @else
                                            <!-- Jika Normal: Otomatis pilih 1x -->
                                            <select name="kelipatan[{{ $anggota->id }}]" class="text-xs font-bold rounded-lg border-slate-200 py-1 px-2 focus:ring-red-500 focus:border-red-500">
                                                <option value="1" selected>1x (Normal)</option>
                                                <option value="2">2x</option>
                                                <option value="3">3x</option>
                                            </select>
                                        @endif
                                    </td>

                                    <!-- 5. CHECKBOX BAYAR -->
                                    <td class="py-3 px-4 text-center">
                                        <input type="checkbox" name="anggota_ids[]" value="{{ $anggota->id }}" class="rounded border-slate-300 text-red-600 focus:ring-red-500 w-4 h-4 cursor-pointer">
                                    </td>

                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Konten Tabel RT 24 -->
                <div x-show="activeTab === 'rt24'" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" style="display: none;">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-500 font-bold">
                                <th class="py-4 px-6">Nama Pemuda</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center">Nominal Wajib</th>
                                <th class="py-4 px-6 text-center text-[10px] font-extrabold text-slate-400 uppercase">Kelipatan</th>
                                <th class="py-4 px-6 text-center">Asok Iuran?</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($anggotaRT24 as $anggota)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                
                                <!-- 1. Kolom Nama -->
                                <td class="py-4 px-6 font-extrabold {{ $anggota->status == 'Sekolah' ? 'text-blue-600' : 'text-slate-900' }}">
                                    {{ $anggota->nama }}
                                </td>

                                <!-- 2. Kolom Status -->
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $anggota->status == 'Sekolah' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $anggota->status }}
                                    </span>
                                </td>

                                <!-- 3. Kolom Nominal Wajib -->
                                <td class="py-4 px-6 text-center font-bold text-slate-700 text-sm">
                                    Rp {{ $anggota->status == 'Sekolah' ? '8.000' : '10.000' }}
                                </td>

                                <!-- 4. KOLOM KELIPATAN BAYAR (Tambahan Baru) -->
                                <td class="py-3 px-4 text-center">
                                    <select name="kelipatan[{{ $anggota->id }}]" class="text-xs font-bold rounded-lg border-slate-200 py-1 px-2 focus:ring-red-500 focus:border-red-500 mr-2 cursor-pointer">
                                        <option value="1">1x</option>
                                        <option value="2">2x</option>
                                        <option value="3">3x</option>
                                    </select>
                                </td>

                                <!-- 5. CHECKBOX BAYAR -->
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="anggota_ids[]" value="{{ $anggota->id }}" class="rounded border-slate-300 text-red-600 focus:ring-red-500 w-4 h-4 cursor-pointer">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Simpan -->
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-extrabold text-sm rounded-xl hover:bg-red-700 shadow-md transition-colors">
                        Simpan Data Iuran
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>