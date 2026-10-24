@php
    // 1. AMBIL DATA SETORAN HUMAS MALAM INI
    $arisanCandi = \App\Models\Iuran::where('status_riwayat', 'aktif')
                    ->whereHas('anggota', function($q) {
                        $q->where('rt', '23'); 
                    })->sum('arisan'); 

    $arisanGunung = \App\Models\Iuran::where('status_riwayat', 'aktif')
                    ->whereHas('anggota', function($q) {
                        $q->where('rt', '24');
                    })->sum('arisan');

    $totalHumas = $arisanCandi + $arisanGunung;

    // 2. CEK RIWAYAT BULAN LALU
    $riwayatBulanLalu = \App\Models\RiwayatArisan::where('status', 'selesai')
                            ->orderBy('tanggal', 'desc')
                            ->first();
    $kekuranganBulanKemarin = $riwayatBulanLalu ? $riwayatBulanLalu->masih_kurang : 0; 
    
    $targetHakTuanRumah = 290000; 

    // 3. LOGIKA JIKA KAS KOSONG VS KAS ADA ISINYA
    if ($totalHumas == 0) {
        // Jika belum ada setoran sama sekali, buat semuanya 0 agar rapi
        $potonganDansos = 0;
        $sisaSetelahDansos = 0;
        $arisanMendapatkan = 0;
        $masihKurangBulanIni = 0;
    } else {
        // Jika sudah ada uang masuk, jalankan rumus normal
        $potonganDansos = 25000;
        $sisaSetelahDansos = $totalHumas - $potonganDansos;
        $arisanMendapatkan = $sisaSetelahDansos - $kekuranganBulanKemarin;
        $masihKurangBulanIni = max(0, $targetHakTuanRumah - $arisanMendapatkan);
    }
@endphp

<!-- GRID LOGIKA KEUANGAN (Mirip Buku Catatan) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-2">
    
    <!-- KOLOM 1: Pemasukan Humas -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-4">Setoran Humas Malam Ini</h3>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center text-sm border-b border-dashed border-slate-200 pb-2">
                    <span class="text-slate-600">Humas Candi</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($arisanCandi, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-sm border-b border-dashed border-slate-200 pb-2">
                    <span class="text-slate-600">Humas Gunung</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($arisanGunung, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div>
            <p class="text-[11px] text-slate-400 mb-1">Total Terkumpul</p>
            <p class="text-2xl font-black text-slate-800">Rp {{ number_format($totalHumas, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- KOLOM 2: Rincian Pembagian & Defisit -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
        <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-6">Rincian Pembagian Arisan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Potongan Dansos & Sisa -->
            <div class="space-y-4">
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-xl flex justify-between items-center border border-red-100">
                    <span class="text-sm font-semibold">Kepotong Dansos</span>
                    <span class="font-black">- Rp {{ number_format($potonganDansos, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center px-4">
                    <span class="text-xs text-slate-500 font-medium">Sisa Tersedia</span>
                    <span class="font-bold text-slate-700">Rp {{ number_format($sisaSetelahDansos, 0, ',', '.') }}</span>
                </div>
                <div class="bg-amber-50 text-amber-700 px-4 py-3 rounded-xl flex justify-between items-center border border-amber-100">
                    <span class="text-sm font-semibold">Tutup Defisit Bln Lalu</span>
                    <span class="font-black">- Rp {{ number_format($kekuranganBulanKemarin, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Hasil Akhir -->
            <div class="flex flex-col justify-center border-t md:border-t-0 md:border-l border-slate-100 pt-6 md:pt-0 md:pl-8">
                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-2">Arisan Mendapatkan</p>
                <p class="text-4xl font-black text-emerald-500 tracking-tight mb-4">Rp {{ number_format($arisanMendapatkan, 0, ',', '.') }}</p>
                
                <div class="inline-flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-lg border border-slate-200">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-xs font-semibold text-slate-600">Masih Kurang: <span class="text-red-500 font-bold">Rp {{ number_format($masihKurangBulanIni, 0, ',', '.') }}</span></span>
                </div>
            </div>

            <!-- FORM SIMPAN LAPORAN (Bagian Manual Petugas) -->
            <!-- FORM SIMPAN LAPORAN -->
            <form id="formSimpanArisan" action="{{ route('arisan.simpan') }}" method="POST" class="mt-8 border-t border-slate-100 pt-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tuan Rumah Malam Ini</label>
                        <input type="text" name="tempat" required placeholder="Contoh: Rumah Mbak Saripla" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Hak (Kesepakatan)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                            <input type="number" name="target_hak" placeholder="150000" class="w-full rounded-xl border-slate-200 pl-10 text-sm font-bold text-slate-800 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                </div>
                <!-- Ubah type menjadi button dan panggil onclick="konfirmasiSimpan()" -->
                <button type="button" onclick="konfirmasiSimpan()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan & Kunci Laporan Malam Ini
                </button>
                
                <!-- TAMBAHAN TEKS LINK RIWAYAT LENGKAP -->
                <div class="mt-5 text-center">
                    <a href="{{ route('arisan.riwayat') }}" class="text-sm font-semibold text-slate-500 hover:text-emerald-600 transition-colors underline decoration-dashed underline-offset-4">
                        Lihat Rincian Laporan Sebelumnya &rarr;
                    </a>
                </div>
            </form>
            </form>
        </div>
    </div>

</div>

<!-- KOTAK UNDIAN (SPINNER DIGITAL) -->
<div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 shadow-lg text-white text-center sm:text-left flex flex-col sm:flex-row items-center justify-between">
    <div>
        <h2 class="text-2xl font-black mb-2">Arisan Selanjutnya Ditempat?</h2>
        <p class="text-indigo-200 text-sm max-w-md">Kocok arisan secara digital! Sistem akan mengacak otomatis anggota yang belum pernah mendapat giliran.</p>
    </div>
    <button type="button" class="mt-6 sm:mt-0 bg-white text-indigo-700 font-black px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
        Mulai Undian
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiSimpan() {
        // Cek dulu apakah input tempat sudah diisi
        const inputTempat = document.querySelector('input[name="tempat"]').value;
        if (!inputTempat) {
            Swal.fire({
                title: 'Data Belum Lengkap!',
                text: 'Silakan isi Tuan Rumah Malam Ini terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#10b981'
            });
            return;
        }

        // Tampilkan Alert Konfirmasi Interaktif
        Swal.fire({
            title: 'Kunci Laporan Malam Ini?',
            text: "Setoran dari Humas akan di-reset dan data tidak bisa diubah lagi!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // Emerald 500
            cancelButtonColor: '#ef4444', // Red 500
            confirmButtonText: 'Ya, Simpan & Kunci!',
            cancelButtonText: 'Batal',
            backdrop: `rgba(0,0,0,0.5)`
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form otomatis jika klik Ya
                document.getElementById('formSimpanArisan').submit();
            }
        });
    }
</script>