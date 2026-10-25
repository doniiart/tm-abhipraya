<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 tracking-tight">Data Sewa Aset</h2>
                <p class="text-sm text-gray-500 font-medium mt-1">Catat dan pantau peminjaman inventaris Karang Taruna.</p>
            </div>
            <!-- Tombol Tambah Sewa (Buka Modal) -->
            <button onclick="document.getElementById('modalTambahSewa').classList.remove('hidden')" class="mt-4 md:mt-0 inline-flex items-center justify-center px-5 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Catat Sewa Baru
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses / Error -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabel Daftar Sewa -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                            <tr>
                                <th class="py-4 px-6 text-center w-16">NO</th>
                                <th class="py-4 px-6">PENYEWA & ALAMAT</th>
                                <th class="py-4 px-6">BARANG DISEWA</th>
                                <th class="py-4 px-6 text-center">TGL SEWA</th>
                                <th class="py-4 px-6 text-center">STATUS</th>
                                <th class="py-4 px-6 text-center w-40">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($sewas as $index => $sewa)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-slate-800">{{ $sewa->nama_penyewa }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $sewa->alamat }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-blue-600">{{ $sewa->aset->nama_aset ?? 'Aset Dihapus' }}</p>
                                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Jumlah: {{ $sewa->jumlah_pinjam }} unit</p>
                                    </td>
                                    <td class="py-4 px-6 text-center font-semibold text-slate-600">
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($sewa->status == 'Disewa')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-wide">Disewa</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wide">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Tombol Kembalikan (Hanya muncul jika status masih Disewa) -->
                                            @if($sewa->status == 'Disewa')
                                                <form id="form-kembali-{{ $sewa->id }}" action="{{ route('sewa.kembalikan', $sewa->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" onclick="konfirmasiKembali({{ $sewa->id }})" class="text-xs font-bold text-emerald-600 bg-emerald-100 hover:bg-emerald-200 px-3 py-1.5 rounded-lg transition-colors">
                                                        Kembali
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Tombol Hapus Riwayat -->
                                            <form action="{{ route('sewa.destroy', $sewa->id) }}" method="POST" class="inline-block" id="form-hapus-sewa-{{ $sewa->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="hapusSewa({{ $sewa->id }})" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus Riwayat">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-3">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="font-medium">Belum ada riwayat penyewaan barang.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 transition flex items-center gap-1">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    <!-- MODAL CATAT SEWA BARU -->
    <div id="modalTambahSewa" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalTambahSewa').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 overflow-hidden max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-black text-gray-900 mb-1">Catat Sewa Baru</h3>
            <p class="text-xs text-slate-500 mb-5">Stok barang akan otomatis dikurangi setelah dicatat.</p>
            
            <form action="{{ route('sewa.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Penyewa</label>
                        <input type="text" name="nama_penyewa" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5" placeholder="Contoh: Bpk. Sugeng">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat</label>
                        <textarea name="alamat" required rows="2" class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5" placeholder="Contoh: RT 24 RW 09"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pilih Barang</label>
                            <select name="aset_id" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5 bg-slate-50 font-medium">
                                <option value="">-- Pilih --</option>
                                @foreach($asets as $aset)
                                    <option value="{{ $aset->id }}">{{ $aset->nama_aset }} (Stok: {{ $aset->jumlah }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jumlah Pinjam</label>
                            <input type="number" name="jumlah_pinjam" required min="1" class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Sewa</label>
                        <input type="date" name="tanggal_sewa" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahSewa').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 bg-gray-50 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 rounded-xl transition shadow-sm">Simpan & Kurangi Stok</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Panggil CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Javascript untuk Modal Hapus Dinamis -->
    <script>
        function hapusSewa(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data riwayat sewa ini akan hilang selamanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#94a3b8',  
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Eksekusi form berdasarkan ID yang diklik
                    document.getElementById('form-hapus-sewa-' + id).submit();
                }
            });
        }
    </script>

    <!-- Panggil Library SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiKembali(id) {
            Swal.fire({
                title: 'Barang Sudah Kembali?',
                text: "Stok inventaris akan otomatis bertambah setelah dikonfirmasi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981', // Warna hijau emerald
                cancelButtonColor: '#ef4444', // Warna merah
                confirmButtonText: 'Ya, Sudah Kembali!',
                cancelButtonText: 'Batal',
                shape: 'rounded-3xl' // Membuat sudut melengkung modern
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika ditekan 'Ya', submit form secara otomatis
                    document.getElementById('form-kembali-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>