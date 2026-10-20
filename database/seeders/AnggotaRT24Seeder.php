<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaRT24Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar pemuda yang di PDF memiliki tanda titik (.)
        $sekolah = [
            'Adi', 'Nino', 'Anggit', 'Nova', 'Najwa', 'Muthia', 'Salsa'
        ];

        // Daftar pemuda sisanya (tidak ada tanda titik)
        $kerja = [
            'Mas Pardi', 'Mas Danang', 'Mas Wardoyo', 'Mas Agung', 'Mas Eko P', 
            'Mas Bambang', 'Mas Santoso', 'Mas Iswanto', 'Dwi Santoso', 'Rizky', 
            'Bintang', 'Rahmad', 'Ari', 'Ilham', 'Nandi', 'Sopyan', 'Tegar', 
            'Adit', 'Ridwan', 'Galang', 'Tyo', 'Eka', 'Reza', 'Imam', 'Widya Eko', 
            'Putri', 'Shinta', 'Tiya', 'Nisa', 'Rina', 'Maya', 'Nafisa', 'Dila'
        ];

        // Masukkan data berstatus Sekolah
        foreach ($sekolah as $nama) {
            Anggota::updateOrCreate(
                ['nama' => $nama, 'rt' => '24'],
                ['status' => 'Sekolah'] // <--- Sudah diganti menjadi 'Sekolah'
            );
        }

        // Masukkan data berstatus Kerja
        foreach ($kerja as $nama) {
            Anggota::updateOrCreate(
                ['nama' => $nama, 'rt' => '24'],
                ['status' => 'Kerja'] 
            );
        }
    }
}