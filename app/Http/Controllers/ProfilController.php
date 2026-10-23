<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingWeb; // Memanggil model SettingWeb

class ProfilController extends Controller
{
    // Menampilkan halaman form edit
    public function edit()
    {
        $settings = SettingWeb::first(); // Ambil data profil saat ini
        return view('profil_edit', compact('settings'));
    }

    // Memproses data yang dikirim dari form
    public function update(Request $request)
    {
        $settings = SettingWeb::first();
        
        // Asumsi kolom yang ada di database Anda: nama_organisasi, deskripsi, tahun_berdiri
        $settings->update([
            'nama_organisasi' => $request->nama_organisasi,
            'deskripsi' => $request->deskripsi,
            'tahun_berdiri' => $request->tahun_berdiri,
            // Tambahkan kolom lain sesuai struktur tabel SettingWeb Anda
        ]);

        return redirect('/profil')->with('success', 'Profil organisasi berhasil diperbarui!');
    }
}