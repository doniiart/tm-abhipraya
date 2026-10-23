<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use App\Models\Aset;
use Illuminate\Http\Request;

class SewaController extends Controller
{
    // 1. Menampilkan Halaman Data Sewa
    public function index()
    {
        // Ambil data sewa dan relasi asetnya
        $sewas = Sewa::with('aset')->orderBy('created_at', 'desc')->get();
        // Ambil data aset yang stoknya masih ada (untuk pilihan di form tambah sewa)
        $asets = Aset::where('jumlah', '>', 0)->get();
        
        return view('persewaan.sewa.index', compact('sewas', 'asets'));
    }

    // 2. Menyimpan Data Sewa & Memotong Stok Aset
    public function store(Request $request)
    {
        $request->validate([
            'nama_penyewa'  => 'required|string|max:255',
            'alamat'        => 'required|string',
            'aset_id'       => 'required|exists:asets,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_sewa'  => 'required|date',
        ]);

        $aset = Aset::findOrFail($request->aset_id);

        // Cek apakah jumlah yang mau dipinjam melebihi stok yang ada
        if ($request->jumlah_pinjam > $aset->jumlah) {
            return back()->with('error', 'Gagal! Stok ' . $aset->nama_aset . ' tidak mencukupi. Sisa stok: ' . $aset->jumlah);
        }

        // Buat data sewa
        Sewa::create([
            'nama_penyewa'  => $request->nama_penyewa,
            'alamat'        => $request->alamat,
            'aset_id'       => $request->aset_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_sewa'  => $request->tanggal_sewa,
            'status'        => 'Disewa',
        ]);

        // Kurangi stok aset di database
        $aset->decrement('jumlah', $request->jumlah_pinjam);

        return redirect()->route('sewa.index')->with('success', 'Data sewa berhasil dicatat! Stok ' . $aset->nama_aset . ' otomatis berkurang.');
    }

    // 3. Mengubah Status Menjadi "Dikembalikan" & Mengembalikan Stok Aset
    public function kembalikan($id)
    {
        $sewa = Sewa::findOrFail($id);

        if ($sewa->status == 'Disewa') {
            // Ubah status
            $sewa->update(['status' => 'Dikembalikan']);
            
            // Kembalikan stok aset
            $aset = Aset::findOrFail($sewa->aset_id);
            $aset->increment('jumlah', $sewa->jumlah_pinjam);

            return back()->with('success', 'Barang berhasil dikembalikan. Stok otomatis bertambah!');
        }

        return back()->with('error', 'Barang ini sudah dikembalikan sebelumnya.');
    }

    // 4. Menghapus Data Sewa (Opsional)
    public function destroy($id)
    {
        $sewa = Sewa::findOrFail($id);

        // Jika dihapus saat statusnya masih "Disewa", kita kembalikan dulu stoknya agar tidak hilang
        if ($sewa->status == 'Disewa') {
            $aset = Aset::findOrFail($sewa->aset_id);
            $aset->increment('jumlah', $sewa->jumlah_pinjam);
        }

        $sewa->delete();

        return redirect()->route('sewa.index')->with('success', 'Riwayat sewa berhasil dihapus.');
    }
}