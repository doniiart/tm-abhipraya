<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 tracking-tight">
            {{ __('Form Manajemen Beranda & Statistik Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl font-bold flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- BAGIAN 1: KHUSUS KETUA & HUMAS -->
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('humas'))
                    <div id="agenda-form" class="border-b border-gray-100 pb-6">
                        <h3 class="text-lg font-black text-gray-900 mb-1">📅 Pengaturan Agenda Kumpulan Pon</h3>
                        <p class="text-sm text-gray-500 mb-4">Dikelola oleh Petugas Humas & Ketua.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Nama Agenda</label>
                                <input type="text" name="agenda_nama" value="{{ $settings['agenda_nama'] ?? 'Kumpulan Rutin Malam Minggu Pon' }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Lokasi</label>
                                <input type="text" name="agenda_lokasi" value="{{ $settings['agenda_lokasi'] ?? 'Kediaman Bapak RT 01' }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Waktu (Jam)</label>
                                <input type="text" name="agenda_waktu" value="{{ $settings['agenda_waktu'] ?? 'Pukul 19.30 WIB' }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Tgl (Angka)</label>
                                    <input type="text" name="agenda_tanggal" value="{{ $settings['agenda_tanggal'] ?? '25' }}" class="w-full rounded-xl border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Bulan</label>
                                    <input type="text" name="agenda_bulan" value="{{ $settings['agenda_bulan'] ?? 'OKTOBER' }}" class="w-full rounded-xl border-gray-300 shadow-sm">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Target Waktu Hitung Mundur (Format: YYYY-MM-DD HH:MM:SS)</label>
                                <input type="text" name="agenda_target_countdown" value="{{ $settings->agenda_target_countdown ?? '2026-11-21 19:30:00' }}" class="w-full rounded-xl border-gray-300">                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- BAGIAN 2: KHUSUS KETUA & TATA USAHA -->
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('tata-usaha'))
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="text-lg font-black text-gray-900 mb-1">👥 Statistik Anggota Aktif</h3>
                        <p class="text-sm text-gray-500 mb-4">Dikelola oleh Tata Usaha & Ketua.</p>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Jumlah Anggota Aktif</label>
                            <input type="text" name="stat_anggota" value="{{ $settings['stat_anggota'] ?? \App\Models\User::count() }}" class="w-full rounded-xl border-gray-300 shadow-sm">
                        </div>
                    </div>
                    @endif

                    <!-- BAGIAN 3: KHUSUS BENDAHARA -->
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('bendahara'))
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="text-lg font-black text-gray-900 mb-1">💰 Transparansi Kas Umum</h3>
                        <p class="text-sm text-gray-500 mb-4">Dikelola oleh Bendahara & Ketua.</p>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Persentase / Status Transparansi Kas</label>
                            <input type="text" name="stat_kas" value="{{ $settings['stat_kas'] ?? '100%' }}" class="w-full rounded-xl border-gray-300 shadow-sm">
                        </div>
                    </div>
                    @endif

                    <!-- BAGIAN 4: KHUSUS DANSOS -->
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('dansos'))
                    <div class="pb-6">
                        <h3 class="text-lg font-black text-gray-900 mb-1">❤️ Kegiatan Sosial & Dana Sosial</h3>
                        <p class="text-sm text-gray-500 mb-4">Dikelola oleh Petugas Dansos & Ketua.</p>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Total Kegiatan Sosial Tercatat</label>
                            <input type="text" name="stat_sosial" value="{{ $settings['stat_sosial'] ?? '36+' }}" class="w-full rounded-xl border-gray-300 shadow-sm">
                        </div>
                    </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-gray-900 hover:bg-red-600 text-white px-8 py-3 rounded-2xl font-bold transition-all shadow-md">
                            Simpan Perubahan Beranda
                        </button>
                    </div>

                </form>
                
            </div>

        </div>
    </div>
</x-app-layout>