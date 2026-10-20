<?php

namespace App\Http\Controllers;

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
            'judul'     => 'required|string|max:255',
            'isi'       => 'required|string',
            'target_rt' => 'required|in:23,24,all',
        ]);

        $user = auth()->user();

        // Validasi Hak Akses RT: Humas 23 hanya boleh kirim ke RT 23, Humas 24 ke RT 24
        if ($user->rt_akses !== 'all' && $user->rt_akses !== $request->target_rt) {
            return back()->with('error', 'Anda hanya memiliki akses untuk mengirim notifikasi ke pemuda RT Anda sendiri.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . config('services.onesignal.rest_api_key'),
            'Content-Type'  => 'application/json',
        ])->post('https://onesignal.com/api/v1/notifications', [
            'app_id'            => config('services.onesignal.app_id'),
            'included_segments' => ['Subscribed Users'], // Kirim ke semua yang sudah klik 'Allow'
            'headings'          => ['en' => $request->judul],
            'contents'          => ['en' => $request->isi],
            'url'               => route('dashboard'), // URL saat notifikasi di layar HP diklik
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Notifikasi pengumuman berhasil dikirimkan!');
    }
}
