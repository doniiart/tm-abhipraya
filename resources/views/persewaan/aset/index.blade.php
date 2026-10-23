<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 tracking-tight">Manajemen Aset</h2>
                <p class="text-sm text-gray-500 font-medium mt-1">Kelola daftar inventaris Persewaan Karang Taruna.</p>
            </div>
            <!-- Tombol Tambah Aset (Buka Modal) -->
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="mt-4 md:mt-0 inline-flex items-center justify-center px-5 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Aset Baru
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabel Daftar Aset -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                            <tr>
                                <th class="py-4 px-6 text-center w-16">NO</th>
                                <th class="py-4 px-6">NAMA ASET</th>
                                <th class="py-4 px-6 text-center w-32">JUMLAH</th>
                                <th class="py-4 px-6 text-center">KONDISI</th>
                                <th class="py-4 px-6 text-center w-32">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($asets as $index => $aset)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6 font-bold text-slate-800">{{ $aset->nama_aset }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-slate-700">{{ $aset->jumlah }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($aset->kondisi == 'Baik')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Baik</span>
                                        @elseif($aset->kondisi == 'Rusak Ringan')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">Rusak Ringan</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Edit -->
                                            <button onclick="bukaModalEdit({{ $aset->id }}, '{{ $aset->nama_aset }}', {{ $aset->jumlah }}, '{{ $aset->kondisi }}')" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('aset.destroy', $aset->id) }}" method="POST" class="inline-block" id="form-hapus-{{ $aset->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="hapusAset({{ $aset->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-3">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <p class="font-medium">Belum ada data aset.</p>
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

    <!-- MODAL TAMBAH ASET -->
    <div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalTambah').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 overflow-hidden">
            <h3 class="text-xl font-black text-gray-900 mb-4">Tambah Aset Baru</h3>
            <form action="{{ route('aset.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Aset</label>
                        <input type="text" name="nama_aset" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5" placeholder="Contoh: Tenda Pramuka">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jumlah</label>
                        <input type="number" name="jumlah" required min="1" class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kondisi</label>
                        <select name="kondisi" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5">
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 bg-gray-50 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 rounded-xl transition shadow-sm">Simpan Aset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ASET -->
    <div id="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalEdit').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 overflow-hidden">
            <h3 class="text-xl font-black text-gray-900 mb-4">Edit Data Aset</h3>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Aset</label>
                        <input type="text" name="nama_aset" id="edit_nama" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jumlah</label>
                        <input type="number" name="jumlah" id="edit_jumlah" required min="0" class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kondisi</label>
                        <select name="kondisi" id="edit_kondisi" required class="w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900 text-sm py-2.5">
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 bg-gray-50 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Javascript untuk Modal Edit -->
    <script>
        function bukaModalEdit(id, nama, jumlah, kondisi) {
            // Isi nilai ke dalam form
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_jumlah').value = jumlah;
            document.getElementById('edit_kondisi').value = kondisi;
            
            // Ubah action form URL agar mengarah ke ID yang benar
            document.getElementById('formEdit').action = "/persewaan/aset/" + id;
            
            // Tampilkan modal
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>

    <!-- Panggil CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Javascript untuk Modal Hapus Dinamis -->
    <script>
        function hapusAset(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data aset ini akan hilang selamanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna merah eksekusi
                cancelButtonColor: '#94a3b8',  // Warna abu-abu batal
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik "Ya, Hapus!", maka form akan dikirim
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>