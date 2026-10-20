<x-app-layout>
    
    <!-- HEADER MODERN -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    Profil Organisasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Mengenal lebih dekat Karang Taruna Tunas Muda Abhipraya
                </p>
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
                    <div class="text-xl font-extrabold text-slate-800">2020</div>
                    <div class="text-xs text-slate-500 mt-1">Terus berkembang hingga saat ini</div>
                </div>

                <!-- Info Alamat -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Pusat Kesekretariatan</div>
                    <div class="text-sm font-extrabold text-slate-800 leading-snug">Dk. Gunung Rejo & Candi</div>
                    <div class="text-xs text-slate-500 mt-1">RT 23 & RT 24, Klaten</div>
                </div>

                <!-- Info Jumlah Anggota -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Kekuatan Anggota</div>
                    <div class="text-xl font-extrabold text-slate-800">60+ Pemuda</div>
                    <div class="text-xs text-slate-500 mt-1">Aktif berpartisipasi dan bersinergi</div>
                </div>
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
</x-app-layout>