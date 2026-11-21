<?php

namespace App\Http\Controllers;

use App\Models\PembelianAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembelianAsetController extends Controller
{
    public function index()
    {
        $pembelians = PembelianAset::with('user')->latest()->get();
        return view('persewaan.pembelian.index', compact('pembelians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'       => 'required|string|max:255',
            'jumlah'            => 'required|integer|min:1',
            'tanggal_pembelian' => 'required|date',
            'total_harga'       => 'required|numeric|min:0',
            'nota'              => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $pathNota = $request->file('nota')->store('nota-pembelian', 'public');

        PembelianAset::create([
            'nama_barang'       => $request->nama_barang,
            'jumlah'            => $request->jumlah,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'total_harga'       => $request->total_harga,
            'nota'              => $pathNota,
            'user_id'           => Auth::id(),
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Laporan pembelian barang & nota berhasil disimpan!');
    }

    public function destroy($id)
    {
        $pembelian = PembelianAset::findOrFail($id);

        if ($pembelian->nota && Storage::disk('public')->exists($pembelian->nota)) {
            Storage::disk('public')->delete($pembelian->nota);
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus!');
    }
}