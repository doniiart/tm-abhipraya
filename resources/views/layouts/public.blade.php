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
    <nav class="bg-white border-b-2 border-red-600 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 flex justify-between items-center h-20">
            <!-- Logo & Nama -->
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo Abhipraya" class="h-12 w-auto drop-shadow-sm">
                <span class="text-xl font-extrabold text-gray-900 hidden sm:block tracking-tight">
                    Tunas Muda <span class="text-red-600">Abhipraya</span>
                </span>
            </a>
            
            <!-- Menu Kanan -->
            <div class="space-x-8 hidden md:flex items-center font-semibold text-sm">
                <a href="/" class="text-gray-600 hover:text-red-600 transition">Beranda</a>
                <a href="/profil" class="text-gray-600 hover:text-red-600 transition">Profil</a>
                <a href="/kegiatan" class="text-gray-600 hover:text-red-600 transition">Kegiatan</a>
                @auth
                    <!-- 🟢 JIKA SUDAH LOGIN: Tampilkan Dropdown -->
                    <div class="relative inline-block group">
                        <!-- Tombol Utama (Pemicu Dropdown) -->
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-amber-400 hover:bg-amber-500 text-slate-900 text-sm font-extrabold rounded-full transition-all shadow-sm hover:shadow-md cursor-pointer">
                            Dashboard Saya
                            <!-- Ikon Panah Bawah -->
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </a>

                        <!-- Kotak Dropdown (Tersembunyi, Muncul saat di-hover) -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform origin-top-right group-hover:translate-y-0 translate-y-2">
                            <div class="py-2">
                                <!-- Pilihan 1: Buka Dashboard -->
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-amber-600 transition-colors">
                                    Buka Dashboard
                                </a>
                                
                                <!-- Pilihan 2: Log Keluar (Logout Form) -->
                                <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                    @csrf
                                    <a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors border-t border-slate-100 mt-1 pt-2">
                                        Log Keluar
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- 🔴 JIKA BELUM LOGIN: Tampilkan tombol 'Log Masuk' -->
                    <a href="{{ route('login') }}" class="inline-flex px-5 py-2.5 bg-amber-400 hover:bg-amber-500 text-slate-900 text-sm font-extrabold rounded-full transition-all shadow-sm hover:shadow-md">
                        Log Masuk
                    </a>
                @endauth
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

</body>
</html>