<x-app-layout>
    
    <!-- HEADER -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    Daftar Anggota
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Total <span class="font-bold text-red-600">{{ $anggotas->count() }}</span> pemuda terdaftar
                </p>
            </div>
            
            <!-- Tombol Kembali ke Dashboard Utama (Beranda) -->
            <a href="{{ url('/#bahagian-agenda') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm transition-all group">
                <svg class="w-4 h-4 mr-1.5 text-slate-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard Utama
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KOTAK TABEL -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <!-- Judul Kolom (Sudah Disesuaikan 5 Kolom) -->
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="py-4 px-6 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest w-12 text-center">No</th>
                                <th class="py-4 px-6 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Nama Pemuda</th>
                                <th class="py-4 px-6 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Jabatan</th>
                                <th class="py-4 px-6 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Domisili</th>
                                <th class="py-4 px-6 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/80">
                            @forelse($anggotas as $index => $anggota)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="py-4 px-6 text-center text-xs font-semibold text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-800 text-sm group-hover:text-red-600 transition-colors">
                                        {{ $anggota->nama }}
                                    </td>
                                    
                                    <!-- Kolom Jabatan -->
                                    <td class="py-4 px-6 text-center">
                                        <span class="text-xs font-semibold {{ ($anggota->jabatan ?? 'Anggota') == 'Anggota' ? 'text-slate-400' : 'text-amber-600' }}">
                                            {{ $anggota->jabatan ?? 'Anggota' }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-bold {{ $anggota->rt == '23' ? 'bg-slate-100 text-slate-600' : 'bg-slate-100 text-slate-600' }}">
                                            RT {{ $anggota->rt }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($anggota->status == 'Kerja')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-sm"></span> Kerja
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-600 border border-sky-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500 shadow-sm"></span> Sekolah
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500 text-sm font-medium">
                                        Belum ada data anggota pemuda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

   <!-- 🌟 TOMBOL SCROLL TO TOP 🌟 -->
    <button id="btn-scroll-top" 
            class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 p-3.5 rounded-full bg-gradient-to-r from-red-600 to-amber-500 text-white shadow-xl shadow-red-500/30 opacity-0 translate-y-10 pointer-events-none transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 hover:scale-110 group">
        <!-- Ikon Panah Ke Atas -->
        <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
    </button>

    <!-- SCRIPT JAVASCRIPT SUPER RESPONSIVE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnScrollTop = document.getElementById('btn-scroll-top');
            
            // 'true' di akhir fungsi ini adalah kunci rahasia untuk mendeteksi scroll di semua elemen!
            window.addEventListener('scroll', function(e) {
                // Deteksi posisi scroll dari window utama ATAU dari elemen div yang sedang di-scroll
                let scrollPos = window.scrollY || document.documentElement.scrollTop;
                
                if (scrollPos === 0 && e.target && e.target.scrollTop) {
                    scrollPos = e.target.scrollTop;
                }

                // Munculkan tombol jika melewati 300px
                if (scrollPos > 300) {
                    btnScrollTop.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
                    btnScrollTop.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                } else {
                    btnScrollTop.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    btnScrollTop.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
                }
            }, true); 

            // Fungsi ketika tombol diklik
            btnScrollTop.addEventListener('click', function() {
                // Kembalikan window ke atas
                window.scrollTo({top: 0, behavior: 'smooth'});
                
                // Kembalikan div kontainer ke atas (jika scroll ada di dalam div)
                const scrollableDivs = document.querySelectorAll('.overflow-y-auto, .overflow-auto');
                scrollableDivs.forEach(div => div.scrollTo({top: 0, behavior: 'smooth'}));
            });
        });
    </script>

</x-app-layout>