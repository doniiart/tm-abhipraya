<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak menumpuk
        Schema::disableForeignKeyConstraints();
        DB::table('anggotas')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();
        
        $pemuda = [
            // ======================================
            // DATA ASLI PEMUDA RT 23
            // Silakan ubah 'Kerja' menjadi 'Sekolah' 
            // untuk nama yang memiliki titik merah
            // ======================================
            ['nama' => 'Wahyu', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Aji', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Beni', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Budi', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Rio', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Arif', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Adam', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Lis', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Fitri', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Herman', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Taufik', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Wahyudi', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Sholikin', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Suyadi', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Latifah', 'rt' => '23', 'status' => 'Sekolah', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Serlita', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Ayuk', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Diana', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Dimas', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Dhika', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Doni', 'rt' => '23', 'status' => 'Kerja', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Aisyah', 'rt' => '23', 'status' => 'Sekolah', 'created_at' => $now, 'updated_at' => $now],
                    ];

        DB::table('anggotas')->insert($pemuda);
    }
}