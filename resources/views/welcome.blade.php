@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
<!-- CSS Tambahan Khusus Animasi Interaktif -->
<style>
    html {
        scroll-behavior: smooth;
    }

    /* Utility untuk Scroll Reveal */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .delay-100 {
        transition-delay: 100ms;
    }

    .delay-200 {
        transition-delay: 200ms;
    }

    .delay-300 {
        transition-delay: 300ms;
    }

    /* Animasi Blob Background */
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    /* Animasi Mengambang Halus */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
</style>

<!-- Hero Section dengan Slideshow Background Otomatis -->
<section class="relative bg-gray-900 text-white min-h-[85vh] flex items-center overflow-hidden">

    <!-- SLIDESHOW BACKGROUND CONTAINER -->
    <div id="hero-slideshow" class="absolute inset-0 z-0">
        <div class="slide absolute inset-0 bg-cover bg-center opacity-100 transition-opacity duration-1000 transform scale-105" style="background-image: url('{{ asset('images/bg1.jpeg') }}');"></div>
        <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 transform scale-105" style="background-image: url('{{ asset('images/bg2.jpeg') }}');"></div>
        <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 transform scale-105" style="background-image: url('{{ asset('images/bg3.jpeg') }}');"></div>
        <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 transform scale-105" style="background-image: url('{{ asset('images/bg4.jpeg') }}');"></div>
        <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 transform scale-105" style="background-image: url('{{ asset('images/bg5.jpeg') }}');"></div>

        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/80 via-gray-900/70 to-gray-950/80"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    </div>

    <div class="container mx-auto relative z-10 px-4 py-20 lg:py-32 flex flex-col items-center text-center">
        <span class="reveal active inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-yellow-400 text-xs font-bold uppercase tracking-widest mb-6 shadow-sm hover:scale-105 transition-transform cursor-default">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-ping"></span>
            Sistem Informasi Digital Resmi
        </span>

        <h1 class="reveal active delay-100 text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 tracking-tight leading-tight drop-shadow-md">
            Sinergi Pemuda,<br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-yellow-400">Membangun Desa</span>
        </h1>

        <p class="reveal active delay-200 text-lg md:text-xl lg:text-2xl mb-10 max-w-3xl mx-auto text-gray-200 font-light leading-relaxed drop-shadow">
            Karang Taruna Tunas Muda Abhipraya.
            <span class="font-medium text-white">Merapatkan ukhuwah, memperkasakan potensi.</span>
        </p>

        <div class="reveal active delay-300 flex flex-col sm:flex-row gap-4 w-full sm:w-auto mb-6">
            <a href="#bagian-galeri" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-500 hover:-translate-y-1 hover:shadow-[0_10px_40px_rgba(250,204,21,0.5)] transition-all duration-300">
                Lihat Agenda
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
            <a href="{{ route('login') }}" onclick="validasiAnggota(event, this.href)" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                Masuk Dashboard
            </a>
        </div>
    </div>
</section>

<!-- Widget Kumpulan Rutin + REAL DATA DARI DATABASE -->
<section id="agenda" class="container mx-auto mt-[-80px] relative z-20 px-4 mb-20 reveal">
    <!-- Tambahan animate-float agar kotak terlihat hidup -->
    <div class="animate-float bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-6 md:p-10 border border-gray-100 relative overflow-hidden group hover:shadow-3xl transition-shadow duration-500">
        <div class="absolute top-0 left-0 w-full h-2 md:h-full md:w-2 bg-red-600 group-hover:bg-yellow-400 transition-colors duration-500"></div>

        <div id="bahagian-agenda" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div class="lg:col-span-2 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 text-red-600 font-bold text-sm uppercase tracking-widest mb-2 group-hover:text-yellow-600 transition-colors duration-500">
                    <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Agenda Utama
                </div>
                <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-2 leading-tight">{{ $agendaTerdekat['nama'] }}</h3>
                <p class="text-gray-500 font-medium text-base mb-4">Lokasi: {{ $agendaTerdekat['lokasi'] }} • {{ $agendaTerdekat['waktu'] }}</p>

                <div class="flex justify-center lg:justify-start gap-3 mt-4">
                    <div class="bg-gray-900 text-white px-4 py-3 rounded-xl text-center min-w-[70px] shadow-lg hover:-translate-y-1 transition-transform">
                        <span id="days" class="block text-2xl font-black text-yellow-400">00</span>
                        <span class="text-[10px] uppercase tracking-wider text-gray-400">Hari</span>
                    </div>
                    <div class="bg-gray-900 text-white px-4 py-3 rounded-xl text-center min-w-[70px] shadow-lg hover:-translate-y-1 transition-transform">
                        <span id="hours" class="block text-2xl font-black text-yellow-400">00</span>
                        <span class="text-[10px] uppercase tracking-wider text-gray-400">Jam</span>
                    </div>
                    <div class="bg-gray-900 text-white px-4 py-3 rounded-xl text-center min-w-[70px] shadow-lg hover:-translate-y-1 transition-transform">
                        <span id="minutes" class="block text-2xl font-black text-yellow-400">00</span>
                        <span class="text-[10px] uppercase tracking-wider text-gray-400">Menit</span>
                    </div>
                    <div class="bg-gray-900 text-white px-4 py-3 rounded-xl text-center min-w-[70px] shadow-lg hover:-translate-y-1 transition-transform">
                        <span id="seconds" class="block text-2xl font-black text-red-500">00</span>
                        <span class="text-[10px] uppercase tracking-wider text-gray-400">Detik</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end items-center">
                <div class="text-center bg-gray-50 border border-gray-200 p-6 rounded-2xl shadow-inner min-w-[140px] transform rotate-2 group-hover:rotate-0 group-hover:scale-105 transition-all duration-300">
                    <span class="block text-5xl font-black text-red-600 tracking-tighter">{{ $agendaTerdekat['tanggal'] }}</span>
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-widest mt-2 block border-t border-gray-200 pt-2">{{ $agendaTerdekat['bulan'] }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Organisasi Dinamis (REAL DATA DARI DATABASE) -->

<!-- Baris 2: Laporan Keuangan & Administrasi -->
<div id="bagian-laporan" class="grid grid-cols-2 gap-4 mt-8">
    <!-- Kotak: Anggota Aktif (Gradasi Merah Halus) -->
    <a href="{{ route('anggota.index') }}" class="group bg-gradient-to-br from-red-50 to-white rounded-2xl shadow-sm border border-red-100 p-6 flex flex-col items-center justify-center hover:shadow-md hover:border-red-200 transition-all duration-300 cursor-pointer">
        <h3 class="text-3xl font-extrabold text-red-600 mb-1 group-hover:scale-110 transition-transform duration-300">
            {{ $settings->stat_anggota ?? '60+' }}
        </h3>
        <p class="text-xs font-bold text-red-400 uppercase tracking-wider mt-2">Anggota Aktif</p>
    </a>

    <!-- Kotak: Kegiatan Sosial (Gradasi Kuning Emas Halus) -->
    <a href="{{ route('kegiatan.publik') }}" class="group bg-gradient-to-br from-amber-50 to-white rounded-2xl shadow-sm border border-amber-100 p-6 flex flex-col items-center justify-center hover:shadow-md hover:border-amber-200 transition-all duration-300 cursor-pointer">
        <h3 class="text-3xl font-black text-amber-500 group-hover:scale-110 transition-transform duration-300">
            {{ $total_kegiatan ?? '0' }}+
        </h3>
        <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mt-2">Kegiatan Sosial</p>
    </a>
</div>

<!-- Baris 2: Laporan Keuangan & Administrasi -->
<!-- Grid Menu Utama yang Dinamis & Hidup -->
<!-- Grid Menu Utama (Responsif & Interaktif Halus) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-6">

    <!-- Kartu 1: Humas (Warna Merah Logo) -->
    <a href="{{ route('laporan.humas') }}" onclick="validasiAnggota(event, this.href)" class="group block bg-gradient-to-br from-red-50 to-white p-6 rounded-2xl shadow-sm border border-red-100 hover:border-red-200 hover:shadow-md transition-all relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 group-hover:bg-red-600 flex items-center justify-center text-red-600 group-hover:text-white font-bold text-sm transition-colors duration-300">
                H
            </div>
            <span class="text-xs font-bold text-red-300 group-hover:text-red-600 transition-colors flex items-center gap-1">
                Buka <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Humas</h3>
        <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider mt-0.5">Laporan Humas</p>
        <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-red-100/50">Arisan, Tabungan, Dansos</p>
    </a>

    <!-- Kartu 2: Arisan -->
    <a href="{{ route('laporan.arisan.publik') }}" onclick="validasiAnggota(event, this.href)" class="group block bg-gradient-to-br from-amber-50 to-white p-6 rounded-2xl shadow-sm border border-amber-100 hover:border-amber-200 hover:shadow-md transition-all relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 group-hover:bg-amber-500 flex items-center justify-center text-amber-600 group-hover:text-white font-bold text-sm transition-colors duration-300">
                A
            </div>
            <span class="text-xs font-bold text-amber-300 group-hover:text-amber-600 transition-colors flex items-center gap-1">
                Buka <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Arisan</h3>
        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mt-0.5">Laporan Arisan</p>
        <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-amber-100/50">Rekap iuran arisan rutin</p>
    </a>

    <!-- Kartu 3: Dansos -->
    <a href="{{ url('/laporan/dansos') }}" onclick="validasiAnggota(event, this.href)" class="group block bg-gradient-to-br from-slate-100 to-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-slate-200 group-hover:bg-slate-800 flex items-center justify-center text-slate-700 group-hover:text-white font-bold text-sm transition-colors duration-300">
                D
            </div>
            <span class="text-xs font-bold text-slate-400 group-hover:text-slate-700 transition-colors flex items-center gap-1">
                Buka <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Dansos</h3>
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Laporan Dansos</p>
        <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-slate-100">Dana sosial & kemasyarakatan</p>
    </a>

    <!-- Kartu 4: Bendahara -->
    <a href="{{ route('public.bendahara') }}" onclick="validasiAnggota(event, this.href)" class="group block bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl shadow-sm border border-orange-100 hover:border-orange-200 hover:shadow-md transition-all relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-orange-100 group-hover:bg-orange-500 flex items-center justify-center text-orange-600 group-hover:text-white font-bold text-sm transition-colors duration-300">
                B
            </div>
            <span class="text-xs font-bold text-orange-300 group-hover:text-orange-600 transition-colors flex items-center gap-1">
                Buka <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Bendahara</h3>
        <p class="text-[10px] font-bold text-orange-500 uppercase tracking-wider mt-0.5">Laporan Bendahara</p>
        <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-orange-100/50">Kas Muda, Kas Tua, Tabungan, Kompensasi</p>
    </a>

    <!-- Kartu 5: Persewaan -->
    <a href="{{ route('laporan.persewaan') }}" onclick="validasiAnggota(event, this.href)" class="group block bg-gradient-to-br from-gray-50 to-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:border-gray-300 hover:shadow-md transition-all relative overflow-hidden">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-gray-200 group-hover:bg-gray-600 flex items-center justify-center text-gray-700 group-hover:text-white font-bold text-sm transition-colors duration-300">
                P
            </div>
            <span class="text-xs font-bold text-gray-400 group-hover:text-gray-700 transition-colors flex items-center gap-1">
                Buka <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Persewaan</h3>
        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-0.5">Laporan Persewaan</p>
        <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-gray-100">Daftar Nama Aset & Persewaan</p>
    </a>

</div>

<!-- Tab Filter Aktivitas -->
<section id="bagian-galeri" class="container mx-auto py-24 px-4">
    <div class="reveal text-center max-w-2xl mx-auto mb-16">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Galeri & Kegiatan Terbaru</h2>
        <p class="text-gray-500 text-lg">Pilih kategori di bawah untuk melihat dokumentasi kegiatan Karang Taruna.</p>

        <div class="flex flex-wrap justify-center gap-3 mt-8">
            <button onclick="filterKegiatan(event, 'all')" class="tab-btn active px-6 py-2.5 rounded-full text-sm font-bold bg-gray-900 text-white shadow-md hover:-translate-y-1 transition-all duration-300">Semua</button>
            <button onclick="filterKegiatan(event, 'kumpulan')" class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold bg-white border border-gray-200 text-gray-700 shadow-sm hover:bg-gray-900 hover:-translate-y-1 transition-all duration-300">Kumpulan Rutin</button>
            <button onclick="filterKegiatan(event, 'sosial')" class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold bg-white border border-gray-200 text-gray-700 shadow-sm hover:bg-gray-900 hover:-translate-y-1 transition-all duration-300">Bakti Sosial</button>
            <button onclick="filterKegiatan(event, 'pemuda')" class="tab-btn px-6 py-2.5 rounded-full text-sm font-bold bg-white border border-gray-200 text-gray-700 shadow-sm hover:bg-gray-900 hover:-translate-y-1 transition-all duration-300">Kepemudaan</button>
        </div>
    </div>

    <div id="kegiatan-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        @forelse($galeris as $index => $item)
        <!-- Kartu Dinamis dari Database -->
        <div class="kegiatan-card {{ $item->kategori }} reveal delay-{{ ($index % 3) * 100 }} bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 hover:-translate-y-2 transition-all duration-500 group cursor-pointer">
            <div class="h-56 overflow-hidden relative bg-gray-100">
                <!-- Menggunakan Storage::url atau asset('storage/...') untuk memanggil foto -->
                <div class="w-full h-full bg-cover bg-center group-hover:scale-110 transition-transform duration-700" style="background-image: url('{{ asset('storage/' . $item->foto) }}');"></div>
            </div>
            <div class="p-8">
                <!-- Label Kategori dengan warna dinamis -->
                @php
                $colorClass = $item->kategori == 'kumpulan' ? 'red' : ($item->kategori == 'sosial' ? 'blue' : 'yellow');
                $kategoriLabel = $item->kategori == 'kumpulan' ? 'Kumpulan Rutin' : ($item->kategori == 'sosial' ? 'Bakti Sosial' : 'Kepemudaan');
                @endphp

                <span class="inline-block text-xs font-bold text-{{ $colorClass }}-600 uppercase tracking-widest bg-{{ $colorClass }}-50 px-3 py-1.5 rounded-lg mb-3">
                    {{ $kategoriLabel }}
                </span>

                <h4 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-{{ $colorClass }}-600 transition-colors duration-300">
                    {{ $item->judul }}
                </h4>

                <p class="text-gray-500 text-sm leading-relaxed">
                    {{ Str::limit($item->deskripsi, 100) }}
                </p>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-3 text-center py-20">
            <p class="text-gray-500 font-medium">Belum ada dokumentasi kegiatan Karang Taruna.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- JavaScript Master -->
<script>
    // 1. Slideshow Background Otomatis
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function changeSlide() {
        slides[currentSlide].classList.remove('opacity-100', 'scale-100');
        slides[currentSlide].classList.add('opacity-0', 'scale-105');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.remove('opacity-0', 'scale-105');
        slides[currentSlide].classList.add('opacity-100', 'scale-100');
    }
    setInterval(changeSlide, 5000);

    // 2. Real Countdown Timer dari Database
    const targetDate = new Date("{{ $agendaTerdekat['full_date'] }}").getTime();
    setInterval(function() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
            document.getElementById("seconds").innerText = "00";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerText = String(days).padStart(2, '0');
        document.getElementById("hours").innerText = String(hours).padStart(2, '0');
        document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
        document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
    }, 1000);

    // 3. Interactive Filter Script 
    // 3. Interactive Filter Script (Logika 1 Foto per Kategori di Tab "Semua")
    function filterKegiatan(event, category) {
        // Mengatur tampilan tombol
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-gray-900', 'text-white', 'shadow-md');
            btn.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
        });

        event.currentTarget.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
        event.currentTarget.classList.add('bg-gray-900', 'text-white', 'shadow-md');

        const cards = document.querySelectorAll('.kegiatan-card');
        const seenCategories = new Set(); // Memori untuk mengingat kategori yang sudah muncul

        cards.forEach(card => {
            // Deteksi kategori dari class kartu ini (kumpulan, sosial, atau pemuda)
            let cardCategory = card.classList.contains('kumpulan') ? 'kumpulan' :
                (card.classList.contains('sosial') ? 'sosial' : 'pemuda');

            if (category === 'all') {
                // Mode "Semua": Cek apakah kategori ini sudah punya perwakilan
                if (!seenCategories.has(cardCategory)) {
                    card.style.display = 'block';
                    seenCategories.add(cardCategory); // Tandai bahwa kategori ini sudah muncul

                    card.style.animation = 'none';
                    card.offsetHeight;
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                } else {
                    card.style.display = 'none'; // Sembunyikan foto ke-2, ke-3, dst di tab Semua
                }
            } else {
                // Mode Kategori Spesifik (misal tab "Kumpulan Rutin" diklik)
                if (card.classList.contains(category)) {
                    card.style.display = 'block'; // Tampilkan SEMUA foto di kategori ini

                    card.style.animation = 'none';
                    card.offsetHeight;
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    // Jalankan fungsi ini otomatis saat halaman pertama kali dimuat
    window.addEventListener('DOMContentLoaded', (event) => {
        const tombolSemua = document.querySelector('.tab-btn');
        filterKegiatan({
            currentTarget: tombolSemua
        }, 'all');
    });

    // 4. Scroll Reveal Animation (Muncul Halus saat di-scroll)
    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100; // Jarak sebelum muncul
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }
    window.addEventListener("scroll", reveal);
    reveal(); // Jalankan sekali saat load

    // 5. Animated Number Counter (Angka berjalan dari 0)
    const counters = document.querySelectorAll('.counter');
    const speed = 50;

    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = +counter.getAttribute('data-target');

                const updateCount = () => {
                    const count = +counter.innerText;
                    const inc = target / speed;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(counter); // Hanya animasi 1x
            }
        });
    }, {
        threshold: 0.5
    });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Tombol Scroll to Top -->
<button id="btnScrollTop" onclick="scrollToTop()" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50 flex items-center justify-center h-14 px-4 rounded-full bg-gradient-to-tr from-red-600 to-amber-500 text-white shadow-[0_10px_20px_rgba(239,68,68,0.4)] hover:shadow-[0_15px_25px_rgba(239,68,68,0.6)] hover:scale-105 transition-all duration-500 opacity-0 translate-y-10 pointer-events-none group">

    <!-- Ikon Panah -->
    <svg class="w-6 h-6 animate-bounce group-hover:animate-none transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>

    <!-- Teks Tersembunyi yang Muncul Saat Disentuh -->


</button>

<!-- Script Penggerak Transisi Mulus -->
<script>
    const btnScrollTop = document.getElementById('btnScrollTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            // Muncul dengan efek mengapung & fade in
            btnScrollTop.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
            btnScrollTop.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
        } else {
            // Hilang dengan efek tenggelam & fade out
            btnScrollTop.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
            btnScrollTop.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
        }
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<!-- Pastikan SweetAlert2 sudah terpasang, jika belum ada, tambahkan baris ini -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function validasiAnggota(event, urlTujuan) {
        event.preventDefault(); // Mencegah link langsung berpindah halaman

        // 1. Cek apakah user sudah pernah memasukkan password sebelumnya
        if (sessionStorage.getItem('anggota_valid') === 'sudah') {
            window.location.href = urlTujuan; // Langsung izinkan masuk
            return;
        }

        // 2. Jika belum, munculkan Pop-up SweetAlert untuk validasi
        Swal.fire({
            title: 'Akses Khusus Anggota',
            text: 'Masukkan password Karang Taruna untuk melihat data:',
            input: 'password',
            inputPlaceholder: 'Masukkan password...',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            icon: 'lock',
            showCancelButton: true,
            confirmButtonText: 'Buka Akses',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#eab308', // Warna kuning keemasan
            cancelButtonColor: '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {

                // UBAH "abhipraya2026" DENGAN PASSWORD YANG ANDA INGINKAN
                if (result.value === 'abhiprayA2324') {

                    // Simpan status bahwa user ini sudah valid
                    sessionStorage.setItem('anggota_valid', 'sudah');

                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Akses dibuka. Selamat datang!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = urlTujuan; // Arahkan ke menu tujuan
                    });

                } else {
                    Swal.fire('Gagal!', 'Password salah. Akses ditolak.', 'error');
                }
            }
        });
    }
</script>
@endsection