<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Siapkan daftar akun demo yang mau dibuat
        $akunDemos = [
            ['name' => 'Mas Humas', 'email' => 'humas@demo.com', 'role' => 'humas'],
            ['name' => 'Mbak Bendahara', 'email' => 'bendahara@demo.com', 'role' => 'bendahara'],
            ['name' => 'Mbak Dansos', 'email' => 'dansos@demo.com', 'role' => 'dansos'],
            ['name' => 'Pak TU', 'email' => 'tu@demo.com', 'role' => 'tata-usaha'],
            ['name' => 'Anggota Biasa', 'email' => 'anggota@demo.com', 'role' => 'anggota'],
        ];

        // 2. Proses pembuatan akun satu per satu
        foreach ($akunDemos as $akun) {
            $user = User::updateOrCreate(
                ['email' => $akun['email']], // Syarat pencarian (Cari email ini)
                [
                    'name' => $akun['name'],
                    'password' => Hash::make('password123'), // Paksa reset/update password ke password123
                    'phone' => '08111222333',
                ]
            );

            // 3. Cari jabatan/role di database, lalu tempelkan ke akun tersebut
            $role = Role::where('slug', $akun['role'])->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}