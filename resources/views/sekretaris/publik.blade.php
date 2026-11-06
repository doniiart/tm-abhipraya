<x-app-layout> <!-- Header & Navigasi Kembali -->
    <div class="bg-white border-b border-slate-200 px-6 py-4 shadow-sm mb-8">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-purple-700 tracking-tight">Buku Induk Sekretaris</h1>
                <p class="text-sm text-slate-500 font-medium">Kesimpulan & Notulensi Terintegrasi</p>
            </div>
            <a href="{{ url('/') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2 px-4 rounded-xl transition-colors text-sm">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <!-- INFO ARISAN SELANJUTNYA -->
        <div style="background: linear-gradient(to right, #7e22ce, #4338ca);" class="rounded-2xl p-6 shadow-lg mb-8 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p style="color: #e9d5ff;" class="text-xs font-bold uppercase tracking-widest mb-1">Arisan Selanjutnya di Tempat</p>
                <h2 class="text-2xl font-bold text-white">
                    {{ $agenda ? $agenda->location : 'Belum Ada Jadwal Arisan' }}
                </h2>
                <p style="color: #f3e8ff;" class="text-sm mt-1 flex items-center gap-2">
                    <span>📝 Keterangan: {{ $agenda ? $agenda->title : '-' }}</span>
                    <span>📅 Tanggal: {{ $agenda ? $agenda->date : '-' }}</span>
                </p>
            </div>
            <div style="background: rgba(255, 255, 255, 0.2); border-color: rgba(255, 255, 255, 0.3);" class="backdrop-blur px-4 py-2 rounded-xl border text-center">
                <p style="color: #f3e8ff;" class="text-[10px] uppercase font-bold">Status Data</p>
                <p class="text-sm font-bold text-white">Sinkronisasi Real-Time</p>
            </div>
        </div>

        <!-- GRID DATA OTOMATIS DARI DIVISI LAIN -->
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-l-4 border-purple-600 pl-3">Rekapitulasi Divisi (Otomatis)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            
            <!-- Kartu Humas -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-red-600 uppercase tracking-widest mb-4">Setoran Humas</h4>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Pihak Candi</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($humasCandi ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Pihak Gunung</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($humasGunung ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-dashed border-slate-200 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Humas Masuk</span>
                    <span class="text-lg font-extrabold text-red-600">Rp {{ number_format(($humasCandi ?? 0) + ($humasGunung ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Kartu Arisan & Dansos -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-amber-600 uppercase tracking-widest mb-4">Arisan</h4>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Total Arisan Bulan ini</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalArisanMasuk ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-red-500">Kepotong Dansos</span>
                        <span class="font-bold text-red-600">- Rp {{ number_format($potonganDansos ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-dashed border-slate-200 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Arisan Bersih didapat</span>
                    <span class="text-lg font-extrabold text-amber-600">Rp {{ number_format(($totalArisanMasuk ?? 0) - ($potonganDansos ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Kartu Bendahara -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between md:col-span-2 lg:col-span-1">
                <div>
                    <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-4">Posisi Kas Bendahara</h4>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Saldo Kas Muda</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalKasMuda ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Saldo Kas Tua</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($totalKasTua ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-dashed border-slate-200 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Uang Kas</span>
                    <span class="text-lg font-extrabold text-emerald-600">Rp {{ number_format(($totalKasMuda ?? 0) + ($totalKasTua ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Kartu Persewaan & Tata Usaha (Placeholder Sementara) -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                    📋
                </div>
                <h4 class="text-sm font-bold text-slate-700 mb-1">Persewaan & Tata Usaha</h4>
                <p class="text-xs text-slate-400">Data otomatis akan muncul di sini setelah ada transaksi pada bulan ini.</p>
            </div>
        </div>
        <!-- Tampilan Publik: Hanya Membaca -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm mt-8 mb-12">
            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Notulensi & Usulan</h4>
            
            <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 min-h-[120px] whitespace-pre-line border border-slate-100">
                {{ $laporanSekretaris ? $laporanSekretaris->usulan_saran : 'Sekretaris belum memasukkan notulensi untuk pertemuan ini.' }}
            </div>
            
            <div class="mt-4">
                <a href="{{ url('/laporan/sekretaris/kesimpulan-keseluruhan') }}" class="block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold py-2 px-6 rounded-xl transition-colors">
                    📄 Lihat Riwayat Kesimpulan
                </a>
            </div>
        </div>

    </div>
</x-app-layout>