<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatArisan;
use Carbon\Carbon;

class RiwayatArisanSeeder extends Seeder
{
    public function run(): void
    {
        // Memasukkan catatan dari buku manual bulan lalu agar sistem punya riwayat
        RiwayatArisan::create([
            'tanggal' => Carbon::now()->subMonth(), // Disetel bulan lalu
            'tempat' => 'Mbak Saripla', // Sesuai foto buku manual
            'pemasukan_candi' => 110000,
            'pemasukan_gunung' => 185000,
            'total_kas_awal' => 295000,
            'potongan_dansos' => 25000,
            'tutup_defisit_lalu' => 0,
            'arisan_mendapatkan' => 190000,
            'target_hak_tuan_rumah' => 270000,
            'masih_kurang' => 80000, // <-- INI DATA DEFISIT YANG AKAN DIBACA SISTEM
            'status' => 'selesai'
        ]);
    }
}