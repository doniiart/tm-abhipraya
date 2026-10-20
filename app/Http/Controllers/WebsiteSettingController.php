<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingWeb;
use App\Models\User;

class WebsiteSettingController extends Controller
{
    // Menampilkan Halaman Form Pengaturan Berdasarkan Role
    public function edit()
    {
        $user = auth()->user();
        
        // Batasi akses: Hanya Ketua, Humas, TU, Bendahara, dan Dansos yang boleh masuk
        if (!($user->hasRole('super-admin') || $user->hasRole('humas') || $user->hasRole('tata-usaha') || $user->hasRole('bendahara') || $user->hasRole('dansos'))) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman pengaturan web.');
        }

        // Ambil data pengaturan dari database
        $settings = SettingWeb::first() ?? new SettingWeb();

        return view('admin.settings.edit', compact('settings'));
    }

    // Menyimpan Perubahan Data Form
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'agenda_nama' => 'required|string|max:255',
            'agenda_lokasi' => 'nullable|string|max:255',
            'agenda_waktu' => 'nullable|string|max:50',
            'agenda_tanggal' => 'nullable|string|max:2',
            'agenda_bulan' => 'nullable|string|max:20',
            'agenda_target_countdown' => 'nullable|string',
            'stat_anggota' => 'nullable|string|max:50',
            'stat_kas' => 'nullable|string|max:50',
            'stat_sosial' => 'nullable|string|max:50',
        ]);

        // 2. KUNCI PERBAIKAN: Gunakan updateOrCreate()
        // Ini akan mencari baris dengan ID 1. Jika ada, ia akan diperbarui.
        // Jika tidak ada, ia akan membuat baris baru dengan ID 1.
        SettingWeb::updateOrCreate(
            ['id' => 1], // Kriteria pencarian (selalu ID 1 karena hanya ada 1 pengaturan)
            $validatedData // Data yang akan disimpan
        );

        return redirect()->route('dashboard')->with('success', 'Beranda publik berhasil diperbarui secara real-time!');
}
}