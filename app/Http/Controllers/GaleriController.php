<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        // Ambil semua galeri beserta data usernya, urutkan dari yang terbaru
        $galeris = Galeri::with('user')->latest()->get();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:kumpulan,sosial,pemuda',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // Simpan file foto ke folder storage/app/public/galeri
        $imagePath = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'foto' => $imagePath,
            'user_id' => auth()->id(), // Mencatat ID user yang sedang login
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto kegiatan berhasil ditambahkan!');
    }

    public function destroy(Galeri $galeri)
    {
        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }
        
        // Hapus data dari database
        $galeri->delete();
        
        return redirect()->route('galeri.index')->with('success', 'Foto kegiatan berhasil dihapus!');
    }
}