<nav x-data="{ open: false }" class="bg-white border-b-2 border-red-600 shadow-sm sticky top-0 z-50">
    <!-- Menu Navigasi Utama (Desktop) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <!-- Area Logo & Nama -->
                <div class="flex items-center gap-2 overflow-visible">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('logo.png') }}" alt="Logo Abhipraya" class="h-8 sm:h-10 w-auto shrink-0 drop-shadow-sm">
                        <span class="font-bold text-[11px] sm:text-base tracking-tight text-gray-900 leading-tight">
                            Tunas Muda <span class="text-red-600">Abhipraya</span>
                        </span>
                    </a>
                </div>

                <!-- Link Menu Dashboard -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-extrabold transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'border-red-600 text-red-600' : 'border-transparent text-gray-600 hover:text-red-600 hover:border-gray-300' }}">
                        Dashboard
                    </a>
                    <!-- Anda bisa menambahkan link menu lain (seperti Keuangan, Usulan) di sini nanti -->
                </div>
            </div>

            <!-- Area Profil Dropdown (Kanan) -->
        @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-yellow-400 text-sm font-bold rounded-full text-gray-800 bg-yellow-100 hover:bg-yellow-400 hover:text-black focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <!-- Menampilkan Nama & Jabatan -->
                            <div>{{ Auth::user()->name }} <span class="font-normal text-xs ml-1 opacity-75">({{ Auth::user()->roles->first()->name ?? 'Anggota' }})</span></div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-medium">
                            ⚙️ {{ __('Pengaturan Akun') }}
                        </x-dropdown-link>

                        <!-- Tombol Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="text-red-600 font-bold hover:bg-red-50">
                                🚪 {{ __('Log Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-slate-900 text-sm font-bold rounded-full transition-all shadow-sm">
                    Log Masuk
                </a>
            </div>
        @endauth
        
            <!-- Hamburger Menu (Mode HP) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Dropdown Mode HP -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-red-600 font-bold bg-red-50 border-red-600">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
                <div class="px-4">
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Pengaturan Akun') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="text-red-600 font-bold">
                            {{ __('Log Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <!-- Tombol Login untuk HP jika pengunjung adalah publik -->
            <div class="pt-4 pb-4 border-t border-gray-200 px-4">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-slate-900 text-sm font-bold rounded-lg transition-all shadow-sm">
                    Log Masuk
                </a>
            </div>
        @endauth
    </div>
</nav>