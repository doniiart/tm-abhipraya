<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    // 1. Menampilkan Halaman Daftar Aset
    public function index()
    {
        // Mengambil semua data aset diurutkan dari yang terbaru
        $asets = Aset::orderBy('created_at', 'desc')->get();
        return view('persewaan.aset.index', compact('asets',));
    }

    // 2. Menyimpan Data Aset Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jumlah'    => 'required|integer|min:1',
            'kondisi'   => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        Aset::create([
            'nama_aset' => $request->nama_aset,
            'jumlah'    => $request->jumlah,
            'kondisi'   => $request->kondisi,
        ]);

        return redirect()->route('aset.index')->with('success', 'Aset baru berhasil ditambahkan!');
    }

    // 3. Mengubah Data Aset
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jumlah'    => 'required|integer|min:0',
            'kondisi'   => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $aset = Aset::findOrFail($id);
        $aset->update([
            'nama_aset' => $request->nama_aset,
            'jumlah'    => $request->jumlah,
            'kondisi'   => $request->kondisi,
        ]);

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    // 4. Menghapus Data Aset
    public function destroy($id)
    {
        $aset = Aset::findOrFail($id);
        $aset->delete();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus!');
    }

    // 5. Menampilkan Halaman Laporan Publik (Read-Only)
    public function laporanPublik()
    {
        // Ambil semua daftar aset
        $asets = \App\Models\Aset::orderBy('nama_aset', 'asc')->get();
        
        // Ambil data sewa (Hanya tampilkan yang statusnya masih "Disewa" saja agar warga tahu barang sedang dibawa siapa)
        $sewas = \App\Models\Sewa::with('aset')
                    ->where('status', 'Disewa')
                    ->orderBy('tanggal_sewa', 'desc')
                    ->get();

        return view('persewaan.laporan_publik', compact('asets', 'sewas'));
    }
}