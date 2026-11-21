<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Header & Tombol Kembali -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Beli / Ganti Baru Inventaris</h2>
                    <p class="text-sm text-slate-500 mt-1">Catat pembelian barang baru atau penggantian barang rusak beserta foto nota.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <!-- Form Input Pembelian -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
                <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-base">🧾</span>
                    Form Input Pembelian & Upload Nota
                </h3>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nama Barang -->
                        <div>
                            <label for="nama_barang" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">Nama Barang yang Dibeli</label>
                            <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required
                                   placeholder="Contoh: Piring Makan Keramik / Gelas Kaca"
                                   class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>

                        <!-- Jumlah Barang -->
                        <div>
                            <label for="jumlah" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">Jumlah Barang (Unit/Pcs/Lusin)</label>
                            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required
                                   placeholder="Contoh: 24"
                                   class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>

                        <!-- Tanggal Pembelian -->
                        <div>
                            <label for="tanggal_pembelian" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                            <input type="date" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" required
                                   class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>

                        <!-- Total Harga -->
                        <div>
                            <label for="total_harga" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">Total Harga Pembelian (Rp)</label>
                            <input type="number" id="total_harga" name="total_harga" value="{{ old('total_harga') }}" min="0" required
                                   placeholder="Contoh: 150000"
                                   class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm">
                        </div>
                    </div>

                    <!-- Upload Nota / Struk -->
                    <div>
                        <label for="nota" class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">Upload Foto Nota / Struk Pembelian</label>
                        <input type="file" id="nota" name="nota" accept="image/png, image/jpeg, image/jpg, image/webp" required
                               onchange="previewNota(event)"
                               class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 border border-slate-200 rounded-xl cursor-pointer">
                        <p class="text-xs text-slate-400 mt-1.5">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran 3 MB.</p>

                        <!-- Preview Gambar Nota -->
                        <div id="preview-container" class="hidden mt-3">
                            <p class="text-xs font-semibold text-slate-500 mb-1">Preview Nota:</p>
                            <img id="nota-preview" src="#" alt="Preview Nota" class="h-40 rounded-xl border border-slate-200 object-cover shadow-sm">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            Simpan Laporan & Nota
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Pembelian -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-extrabold text-slate-800">Riwayat Pembelian & Nota Tersimpan</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3.5 px-4 font-extrabold">Tanggal</th>
                                <th class="py-3.5 px-4 font-extrabold">Nama Barang</th>
                                <th class="py-3.5 px-4 font-extrabold">Jumlah</th>
                                <th class="py-3.5 px-4 font-extrabold">Total Harga</th>
                                <th class="py-3.5 px-4 font-extrabold">Nota / Struk</th>
                                <th class="py-3.5 px-4 font-extrabold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($pembelians as $item)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        {{ $item->nama_barang }}
                                        <span class="block text-xs font-normal text-slate-400">Input: {{ $item->user->name ?? 'Petugas' }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700 font-semibold">{{ $item->jumlah }} pcs</td>
                                    <td class="py-3.5 px-4 font-extrabold text-emerald-600 whitespace-nowrap">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <a href="{{ asset('storage/' . $item->nota) }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 text-xs font-bold transition">
                                            Lihat Nota ↗
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" class="inline form-hapus" data-nama="{{ $item->nama_barang }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-hapus-swal text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400 text-sm">
                                        Belum ada data pembelian barang baru yang dicatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function previewNota(event) {
            const input = event.target;
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('nota-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#f59e0b'
            });
        @endif

        document.querySelectorAll('.btn-hapus-swal').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const nama = form.getAttribute('data-nama') || 'data ini';

                Swal.fire({
                    title: 'Hapus Data Pembelian?',
                    text: "Data pembelian '" + nama + "' dan foto notanya akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>