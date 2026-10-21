<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('') Tunas Muda Abhipraya</title>
    
    <!-- Font Modern & Kekinian: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
                <a href="/kegiatan" class="text-gray-600 hover:text-red-600 transition duration-300 hover:-translate-y-0.5">Kegiatan</a>
                
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
                    <a href="/kegiatan" class="block py-3 hover:bg-white/60 rounded-2xl hover:text-red-600 hover:-translate-y-0.5 transition-all duration-300">Kegiatan</a>
                    
                    <div class="pt-4 mt-2 border-t border-gray-400/20">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full py-3.5 bg-amber-400/90 hover:bg-amber-400 text-slate-900 rounded-2xl mb-3 shadow-[0_8px_20px_rgba(251,191,36,0.25)] hover:-translate-y-1 transition-all duration-300">
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

    <!-- Footer Modern -->
    <footer class="bg-gray-900 text-gray-400 py-12 mt-12 border-t-4 border-red-600">
        <div class="container mx-auto px-4 text-center">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 mx-auto mb-6 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition duration-500">
            <h3 class="text-white font-bold text-lg mb-2">Karang Taruna Tunas Muda Abhipraya</h3>
            <p class="text-sm">&copy; {{ date('Y') }} Hak Cipta Terpelihara.</p>
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