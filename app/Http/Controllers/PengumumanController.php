<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Models\User;

class PengumumanController extends Controller
{
    public function create()
    {
        return view('pengumuman.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'target_rt' => 'required|in:23,24,all',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // Validasi Hak Akses RT
        if ($user->rt_akses !== 'all' && $user->rt_akses !== $request->target_rt) {
            return back()->with('error', 'Anda hanya memiliki akses untuk mengirim notifikasi ke pemuda RT Anda sendiri.');
        }

        // 1. Simpan data pengumuman ke database (opsional, sesuaikan jika sudah ada model Pengumuman)
        // $pengumuman = \App\Models\Pengumuman::create($request->all());

        // Jika belum ada model/tabel pengumuman dan hanya ingin mengirim datanya langsung ke notifikasi:
        $pengumuman = (object) [
            'judul' => $request->judul,
            'isi' => $request->isi
        ];

        // 2. Ambil user yang memiliki langganan push notification
        $query = User::has('pushSubscriptions');

        // Jika ingin memfilter berdasarkan target RT yang dipilih di form
        if ($request->target_rt !== 'all') {
            $query->where('rt_akses', $request->target_rt);
        }

        $usersWithSubscriptions = $query->get();

        // 3. Kirim notifikasi secara otomatis jika ada perangkat yang terdaftar
        if ($usersWithSubscriptions->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($usersWithSubscriptions, new \App\Notifications\NewAnnouncementNotification($pengumuman));
        }

        return redirect()->route('dashboard')->with('success', 'Notifikasi pengumuman berhasil dikirimkan!');
    }
}
