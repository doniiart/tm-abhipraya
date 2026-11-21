<x-guest-layout>
    
    <!-- HEADER INTERAKTIF (LOGO & SAPAAN) -->
    <x-slot name="header">
        <div class="text-center group cursor-default">
            <!-- Logo dengan Cahaya Belakang -->
            <a href="/" class="inline-block relative">
                <div class="absolute inset-0 bg-yellow-400/30 rounded-full blur-2xl transition-all duration-700 group-hover:bg-red-500/40 group-hover:scale-150"></div>
                <img src="{{ asset('logo.png') }}" alt="Logo Tunas Muda Abhipraya" 
                     class="w-28 h-28 mx-auto relative z-10 drop-shadow-xl transition-all duration-500 transform group-hover:scale-110 group-hover:-translate-y-2">
            </a>
            
            <!-- Teks Animasi -->
            <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-slate-900 transition-all duration-300">
                Selamat Datang, <br/>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-600 via-red-500 to-yellow-500 animate-pulse inline-block transform group-hover:scale-105 transition-transform duration-300">
                    Para Petugas! 👋
                </span>
            </h2>
            <p class="mt-3 text-sm text-slate-500 font-medium max-w-sm mx-auto leading-relaxed opacity-90">
                Silakan masuk untuk mengelola sistem informasi digital Karang Taruna Tunas Muda Abhipraya.
            </p>
        </div>
    </x-slot>

    <!-- FORM LOGIN DALAM KOTAK KACA -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address dengan Ikon -->
        <div class="relative group/input">
            <label for="email" class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-red-600">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within/input:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="block w-full pl-11 py-3 text-sm border-slate-200/80 rounded-2xl focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white/50 focus:bg-white placeholder:text-slate-400 shadow-sm hover:border-red-300"
                       placeholder="contoh: emailmu.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password dengan Ikon -->
        <div class="relative group/input">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider transition-colors group-focus-within/input:text-red-600">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-slate-400 hover:text-red-600 transition-colors">
                        Lupa Sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within/input:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-11 py-3 text-sm border-slate-200/80 rounded-2xl focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white/50 focus:bg-white"
                    placeholder="hanya petugas yang tau">

                <!-- Tombol Lihat Password (Sisipkan di sini, sebelum </div>) -->
                <button type="button" id="toggle-password" aria-label="Lihat Kata Sandi"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                    <!-- Ikon Mata Terbuka -->
                    <svg id="eye-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Dicoret -->
                    <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 focus:ring-offset-0 transition-colors cursor-pointer">
            <label for="remember_me" class="ml-2.5 text-sm font-semibold text-slate-600 cursor-pointer select-none">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Tombol Login Efek Sapuan Cahaya -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-red-600 to-yellow-500 text-white font-bold py-4 rounded-2xl text-sm transition-all duration-300 hover:shadow-[0_8px_20px_rgba(220,38,38,0.3)] hover:-translate-y-1 relative overflow-hidden group">
                <span class="relative z-10 tracking-wide">Masuk ke Sistem</span>
                <svg class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                
                <!-- Efek Sapuan Cahaya (Shine Effect) -->
                <div class="absolute top-0 -left-[100%] w-[120%] h-full bg-gradient-to-r from-transparent via-white/30 to-transparent transform skew-x-[20deg] transition-all duration-700 group-hover:left-[100%] z-0"></div>
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('toggle-password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }
        });
    </script>
</x-guest-layout>