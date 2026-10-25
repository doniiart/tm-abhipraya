<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('') Tunas Muda Abhipraya</title>
    
    <!-- Font Modern & Kekinian: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Navbar Bersih & Elegan -->
    <!-- Navbar Bersih, Elegan & Responsif -->
    <nav class="bg-white/95 backdrop-blur border-b-2 border-red-600 shadow-sm sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 flex justify-between items-center h-20 relative">
            
            <!-- Logo & Nama (Selalu terlihat di HP dan Desktop) -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3 z-20">
                <img src="{{ asset('logo.png') }}" alt="Logo Abhipraya" class="h-10 sm:h-12 w-auto drop-shadow-sm transition-transform hover:scale-105 duration-300">
                <span class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Tunas Muda <span class="text-red-600">Abhipraya</span>
                </span>
            </a>

            <!-- Tombol Hamburger (Khusus Mobile) -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors z-20 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Menu Kanan (Desktop) -->
            <div class="hidden md:flex items-center space-x-8 font-semibold text-sm">
                <a href="/" class="text-gray-600 hover:text-red-600 transition duration-300 hover:-translate-y-0.5">Beranda</a>
                <a href="/profil" class="text-gray-600 hover:text-red-600 transition duration-300 hover:-translate-y-0.5">Profil</a>
                <a href="{{ route('kegiatan.publik') }}" class="text-gray-600 hover:text-red-600 transition duration-300 hover:-translate-y-0.5">Kegiatan</a>
                
                @auth
                    <!-- JIKA SUDAH LOGIN: Tampilkan Dropdown -->
                    <div class="relative group">
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-amber-400 hover:bg-amber-500 text-slate-900 rounded-full transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                            Dashboard Saya
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        
                        <!-- Kotak Dropdown (Desktop) -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                            <div class="py-2">
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">Buka Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors border-t border-slate-100 mt-1">
                                        Log Keluar
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- JIKA BELUM LOGIN -->
                    <a href="{{ route('login') }}" class="inline-flex px-5 py-2.5 bg-amber-400 hover:bg-amber-500 text-slate-900 text-sm font-extrabold rounded-full transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                        Log Masuk
                    </a>
                @endauth
            </div>

            <!-- Menu Dropdown (Khusus Mobile - Muncul saat Hamburger diklik) -->
            <div id="mobile-menu" class="absolute inset-x-0 top-full bg-white/60 backdrop-blur-lg border-b border-white/40 shadow-[0_20px_40px_rgba(0,0,0,0.1)] md:hidden transition-all duration-300 origin-top transform scale-y-0 opacity-0 z-40 rounded-b-3xl">
                
                <div class="px-6 py-6 space-y-2 text-center flex flex-col font-bold text-gray-800">
                    <!-- Efek dinamis: hover:bg-white/50 (kotak transparan saat disentuh) dan sedikit naik (hover:-translate-y-0.5) -->
                    <a href="/" class="block py-3 hover:bg-white/60 rounded-2xl hover:text-red-600 hover:-translate-y-0.5 transition-all duration-300">Beranda</a>
                    <a href="/profil" class="block py-3 hover:bg-white/60 rounded-2xl hover:text-red-600 hover:-translate-y-0.5 transition-all duration-300">Profil</a>
                    <a href="{{ route('kegiatan.publik') }}" class="block py-3 hover:bg-white/60 rounded-2xl hover:text-red-600 hover:-translate-y-0.5 transition-all duration-300">Kegiatan</a>
                    
                    <div class="pt-4 mt-2 border-t border-gray-400/20">
                        @auth
                            <a href="{{ url('/dashboard') }}" onclick="validasiAnggota(event, this.href)" class="block w-full py-3.5 bg-amber-400/90 hover:bg-amber-400 text-slate-900 rounded-2xl mb-3 shadow-[0_8px_20px_rgba(251,191,36,0.25)] hover:-translate-y-1 transition-all duration-300">
                                Buka Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full py-3 bg-white/40 hover:bg-red-50 hover:text-red-600 text-slate-600 rounded-2xl hover:-translate-y-0.5 transition-all duration-300">
                                    Log Keluar
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-3.5 bg-amber-400/90 hover:bg-amber-400 text-slate-900 rounded-2xl shadow-[0_8px_20px_rgba(251,191,36,0.25)] hover:-translate-y-1 transition-all duration-300">
                                Log Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Kandungan Utama -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- FOOTER MODERN 4 KOLOM -->
    <footer class="bg-slate-900 text-slate-300 border-t-4 border-red-600 relative overflow-hidden mt-12" style="font-family: 'Nunito', sans-serif;">
        <!-- Efek Cahaya Latar Belakang (Opsional untuk estetika) -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                
                <!-- KOLOM 1: IDENTITAS & DESKRIPSI -->
                <div class="space-y-6">
                    <!-- Logo & Nama -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-1 shadow-lg">
                            <!-- Ganti src dengan path logo asli jika ada -->
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain" onerror="this.outerHTML='<span class=\'text-2xl\'>🛡️</span>'">
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-white tracking-tight">Tunas Muda</h2>
                            <p class="text-red-500 font-bold text-sm -mt-1">Abhipraya</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Organisasi kepemudaan yang berdedikasi untuk memajukan kesejahteraan sosial, gotong royong, dan pemberdayaan masyarakat di lingkungan Desa.
                    </p>
                    <!-- Sosial Media -->
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Ikuti Kami</p>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="https://www.instagram.com/tunasmuda_abhiprayaa/" class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <a href="https://www.tiktok.com/@tunasmudaabhiprayaa" class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors" title="TikTok">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- KOLOM 2: LAYANAN ORGANISASI -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Layanan Sistem</h3>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Arisan Rutin</a></li>
                        <li><a href="{{ url('/laporan/dansos') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Dana Sosial (Dansos)</a></li>
                        <li><a href="{{ route('public.bendahara') }}#" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Laporan Bendahara</a></li>
                        <li><a href="{{ route('laporan.persewaan') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Persewaan Inventaris</a></li>
                        <li><a href="{{ route('laporan.humas') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Humas & Pengumuman</a></li>
                    </ul>
                </div>

                <!-- KOLOM 3: HUBUNGI KAMI (Box Style) -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Hubungi Kami</h3>
                    <div class="space-y-3">
                        <!-- Box Alamat -->
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex gap-4 hover:bg-white/10 transition-colors">
                            <div class="mt-0.5 text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Alamat Sekretariat</p>
                                <p class="text-sm text-slate-300">Dukuh Candirejo & Gunungrejo,<br>Wonosari, Kabupaten Klaten, Jawa Tengah</p>
                            </div>
                        </div>
                        <!-- Box Telepon -->
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex gap-4 hover:bg-white/10 transition-colors">
                            <div class="mt-0.5 text-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">WhatsApp / Telepon</p>
                                <p class="text-sm text-slate-300">Mohon maaf belum tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM 4: PETA LOKASI -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Peta Lokasi</h3>
                    <div id="peta-lokasi" class="bg-slate-800 rounded-2xl p-2 border border-slate-700 shadow-inner h-48 relative overflow-hidden group">
                        <!-- Google Maps Iframe (Ganti src dengan embed map asli sekretariat Anda) -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d967.4573578088114!2d110.74373498619279!3d-7.64215738566555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sid!4v1792715831720!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
                
            </div>

            <!-- BOTTOM BAR: COPYRIGHT & LINKS -->
            <div class="mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} Karang Taruna Tunas Muda Abhipraya. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');

            btn.addEventListener('click', function() {
                if (menu.classList.contains('scale-y-0')) {
                    // Buka menu (animasi dari atas ke bawah)
                    menu.classList.remove('scale-y-0', 'opacity-0');
                    menu.classList.add('scale-y-100', 'opacity-100');
                } else {
                    // Tutup menu
                    menu.classList.remove('scale-y-100', 'opacity-100');
                    menu.classList.add('scale-y-0', 'opacity-0');
                }
            });
        });
    </script>

</body>
</html>