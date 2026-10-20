<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    //Menampilkan daftar kumpulan
    public function index()
    {
        $meetings = Meeting::orderBy('data', 'desc')->paginate(10);
        return view('admin.meetings.index', compact('meetings'));
    }

    //menyimpan jadwal kumpulan baru beserta susunan acaranya
    public function store(Request $request)
    {
        //validasi input form biar data gak sembarangan 
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'javanese_date' => 'nullable|string',
            'location' => 'required|string',
            'host_name' => 'required|string',
        ]);

        $validated['created_by'] = auth()->id(); //id pengurus yang sedang login
        $meetings = Meeting::create($validated);
        //otomatis buatkan susunan acara standar kartar
        $defaultAgendas = [
            'Pembukaan', 'Sambutan Tuan Rumah', 'Sambutan Ketua', 
            'Latihan Diplomasi', 'Laporan Humas', 'Laporan Dansos', 
            'Laporan Bendahara', 'Laporan TU', 'Sesi Usulan', 
            'Pembinaan / Tausiyah', 'Kesimpulan & Keputusan', 'Penutup'
        ];

        foreach ($defaultAgendas as $index => $sessionName) {
            $meeting->agendas()->create([
                'session_name' => $sessionName,
                'order_no' => $index + 1
            ]);
        }

        return redirect()->back()->with('succes', 'Jadwal kumpulan berhasil dibuat!');
    }
}
