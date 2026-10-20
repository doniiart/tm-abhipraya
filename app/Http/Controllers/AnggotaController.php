<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        // Mengambil semua data anggota, diurutkan berdasarkan RT lalu Nama
        $anggotas = Anggota::orderBy('rt', 'asc')->orderBy('nama', 'asc')->get();
        
        return view('anggota.index', compact('anggotas'));
    }
}