<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Tombol Kembali -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold tracking-widest text-emerald-500 uppercase">Buku Kas Organisasi</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Rincian Tabungan</h1>
                    <p class="text-sm text-slate-500 mt-1">Rekapitulasi seluruh setoran tabungan pemuda dari Humas RT 23 & 24.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <!-- Tabel Riwayat Tabungan -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-2xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-emerald-50/50 border-b border-emerald-100">
                            <tr>
                                <th scope="col" class="py-4 px-6 text-xs font-extrabold text-slate-700 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="py-4 px-6 text-xs font-extrabold text-slate-700 uppercase tracking-wider">Nama Pemuda</th>
                                <th scope="col" class="py-4 px-6 text-xs font-extrabold text-slate-700 uppercase tracking-wider">Nominal Tabungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @forelse($riwayatTabungan as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3 px-6 text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <!-- Memanggil relasi anggota (sama seperti yang Mas Doni buat di Humas) -->
                                    <td class="py-3 px-6 text-slate-800 font-semibold">{{ $item->anggota->nama ?? '-' }}</td>
                                    <td class="py-3 px-6 text-emerald-600 font-bold">Rp {{ number_format($item->tabungan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center text-slate-400 text-sm">Belum ada riwayat setoran tabungan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-100 font-bold">
                            <tr>
                                <td colspan="2" class="py-4 px-6 text-right text-xs uppercase tracking-wider text-slate-600">Total Keseluruhan</td>
                                <td class="py-4 px-6 text-emerald-600 text-base">
                                    Rp {{ number_format($riwayatTabungan->sum('tabungan'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
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