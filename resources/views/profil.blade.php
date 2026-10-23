<x-app-layout>
    
    <!-- HEADER MODERN -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-start justify-between mb-6 w-full">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Profil Organisasi</h2>
                <p class="text-sm text-gray-500 mt-1">Mengenal lebih dekat Karang Taruna Tunas Muda Abhipraya</p>
            </div>
            
            <!-- Tampilkan Tombol Edit HANYA jika petugas sudah Login -->
            @auth
                <a href="{{ url('/profil/edit') }}" class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl shadow-md hover:bg-slate-800 hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="hidden sm:inline">Edit Profil</span>
                </a>
            @else
                <!-- Ikon Dokumen Statis (Hanya muncul untuk warga/publik yang belum login) -->
                <button onclick="bukaModalDiplomasi()" title="Teks Diplomasi" class="p-2.5 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6 text-gray-500 hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </button>
            @endauth
        </div>
            
            <!-- Tombol Kembali -->
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm transition-all group">
                <svg class="w-4 h-4 mr-1.5 text-slate-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER / BANNER PROFIL -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative">
                <!-- Ornamen Latar -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-red-100 to-amber-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                
                <div class="p-8 sm:p-10 relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-8">
                    <!-- Logo Besar -->
                    <div class="w-32 h-32 shrink-0 bg-slate-50 rounded-full p-4 border border-slate-100 shadow-sm flex items-center justify-center">
                        <!-- Jika ada logo, ganti teks ini dengan tag <img> -->
                        <img src="{{ asset('logo.png') }}" alt="Logo Abhipraya" class="w-full h-full object-contain">
                    </div>
                    
                    <div class="text-center sm:text-left">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-600 mb-3 border border-red-100">
                            Organisasi Kepemudaan
                        </div>
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Tunas Muda Abhipraya</h3>
                        <p class="text-slate-500 leading-relaxed max-w-2xl text-sm">
                            Wadah pengembangan generasi muda yang tumbuh dan berkembang atas dasar kesadaran dan tanggung jawab sosial dari, oleh, dan untuk masyarakat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- GRID INFORMASI SINGKAT -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Berdiri -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Tahun Berdiri</div>
                    <p class="text-xl font-bold text-slate-900 mt-1">
                        {{ $settings->tahun_berdiri}}
                    </p>
                    <div class="text-xs text-slate-500 mt-1">Terus berkembang hingga saat ini</div>
                </div>

                <!-- Info Alamat / Pusat Kesekretariatan (Bisa Diklik) -->
                <a href="{{ url('/') }}#peta-lokasi" class="block bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-100 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1 group-hover:text-blue-500 transition-colors">Pusat Kesekretariatan</div>
                    <div class="text-sm font-extrabold text-slate-800 leading-snug">Dk. Candi Rejo & Gunung Rejo</div>
                    <div class="text-xs text-slate-500 mt-1">RT 23 & RT 24, Wonosari, Klaten</div>
                </a>

                <!-- Info Jumlah Anggota (Sekarang Bisa Diklik) -->
                <a href="{{ url('/anggota') }}" class="block bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:border-emerald-200 hover:-translate-y-1 transition-all duration-300 group cursor-pointer">
                    
                    <!-- Ikon -->
                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:bg-emerald-100 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Teks -->
                    <div class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1 group-hover:text-emerald-500 transition-colors">Kekuatan Anggota</div>
                    <div class="text-xl font-extrabold text-slate-800">
                        <!-- Jika angka ini juga ingin dibuat dinamis dari database -->
                        {{ $settings?->stat_anggota ?? '60+' }} Pemuda
                    </div>
                    <div class="text-xs text-slate-500 mt-1">Aktif berpartisipasi dan bersinergi</div>
                </a>
            </div>

            <!-- VISI & MISI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Visi -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 sm:p-10 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 text-white/5">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-amber-400 font-extrabold tracking-widest text-sm mb-4 uppercase">Visi Kami</div>
                        <p class="text-lg sm:text-xl font-medium leading-relaxed">
                            "Mewujudkan generasi muda yang produktif, inovatif, dan berakhlak mulia demi terciptanya kesejahteraan sosial masyarakat di lingkungan Candirejo dan Gunungrejo."
                        </p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 border border-slate-100">
                    <div class="text-red-600 font-extrabold tracking-widest text-sm mb-6 uppercase">Misi Kami</div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">1</span>
                            <span class="text-sm text-slate-600 font-medium">Mempererat tali persaudaraan antar pemuda di lingkungan RT 23 dan RT 24.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">2</span>
                            <span class="text-sm text-slate-600 font-medium">Menyelenggarakan kegiatan positif di bidang sosial, keagamaan, olahraga, dan seni budaya.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">3</span>
                            <span class="text-sm text-slate-600 font-medium">Meningkatkan kesadaran masyarakat akan pentingnya kebersihan dan kelestarian lingkungan.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

        <div id="modal-container" class="fixed inset-0 z-[99] hidden items-center justify-center px-4">
    <!-- Latar Belakang Blur dengan Animasi Fading -->
    <div id="modal-backdrop" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out" onclick="tutupModalDiplomasi()"></div>
    
    <!-- Kartu Teks Diplomasi dengan Animasi Scale (Membesar) -->
    <div id="modal-card" class="relative bg-white w-full max-w-lg rounded-[2rem] shadow-2xl p-6 sm:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col max-h-[90vh]">
        
        <!-- Tombol Silang (X) Interaktif (Berputar saat di-hover) -->
        <button onclick="tutupModalDiplomasi()" class="absolute top-6 right-6 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-full p-2 transition-all duration-300 hover:rotate-90">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Header Elegan dengan Gradasi -->
        <div class="flex items-center gap-4 mb-6">
            <div class="p-3 bg-gradient-to-br from-red-50 to-red-100 rounded-2xl text-red-600 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Teks Diplomasi</h3>
                <p class="text-sm font-medium text-slate-500 mt-0.5">Dokumen Resmi Karang Taruna</p>
            </div>
        </div>
        
        <!-- Garis Pembatas Tipis -->
        <div class="w-full h-px bg-gradient-to-r from-slate-100 via-slate-200 to-transparent mb-6"></div>
        
        <!-- Isi Teks (Scrollable, Rapi, Teks Justify) -->
        <div class="text-slate-600 text-[15px] leading-relaxed overflow-y-auto pr-3 flex-1">
            <p class="mb-5 text-justify">
                 Assalamualaikum Wr. Wb. Keparing matur dumateng poro tamu sedoyo, gegandengan kadang kaniman sampun cekap anggenipun ngladosaken unjukan soho nyamikan sampun cekap lan sampun sumadyo ing ngarsanipun panjenengan sami awet keparingipun <span class="font-bold text-slate-800">Mas/Mba (yang punya rumah)</span> kawulo suwun <span class="font-bold text-slate-800">Bapak (yang paling tua)</span> nyumangga aken poro tamu sedoyo,
                wedal pangandikan ipun sak cekap ipun mbok menawi wonten klenta klentu kawulo, kulo nyuwun pangapunten Wassalamualaikum Wr. Wb.
            </p>
            
        </div>
        
        <!-- Tombol Tutup Elegan -->
        <div class="mt-8 pt-2 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
            
            <!-- Tombol Tutup (Diubah warnanya agar lebih netral) -->
            <button onclick="tutupModalDiplomasi()" class="w-full sm:w-auto px-6 py-3 text-slate-500 hover:text-slate-800 font-bold rounded-2xl hover:bg-slate-100 transition-all duration-300 text-sm">
                Tutup Dokumen
            </button>

            <!-- Tombol Download JPEG -->
            <a href="{{ asset('/images/teks-diplomasi.jpg') }}" download="teks-diplomasi.jpg" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-bold rounded-2xl shadow-lg shadow-red-200 hover:shadow-red-300 hover:-translate-y-0.5 transition-all duration-300 text-sm flex items-center justify-center gap-2">
                <!-- Ikon Download -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh Gambar
            </a>

        </div>
    </div>
</div>

<!-- SCRIPT UNTUK ANIMASI MUNCUL/HILANG YANG HALUS -->
<script>
    function bukaModalDiplomasi() {
        let container = document.getElementById('modal-container');
        let backdrop = document.getElementById('modal-backdrop');
        let card = document.getElementById('modal-card');
        
        // Tampilkan wadah utama
        container.classList.remove('hidden');
        container.classList.add('flex');
        
        // Jeda sangat singkat (10ms) agar browser merender animasi CSS-nya
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            
            card.classList.remove('opacity-0', 'scale-95');
            card.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function tutupModalDiplomasi() {
        let container = document.getElementById('modal-container');
        let backdrop = document.getElementById('modal-backdrop');
        let card = document.getElementById('modal-card');
        
        // Putar animasi mundur (menghilang & mengecil)
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        
        card.classList.remove('opacity-100', 'scale-100');
        card.classList.add('opacity-0', 'scale-95');
        
        // Sembunyikan wadah sepenuhnya setelah durasi animasi selesai (300ms)
        setTimeout(() => {
            container.classList.remove('flex');
            container.classList.add('hidden');
        }, 300);
    }
</script>
</x-app-layout>