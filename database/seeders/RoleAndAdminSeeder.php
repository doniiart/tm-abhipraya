<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
        ['name' => 'Petugas Humas', 'slug' => 'humas'],
        ['name' => 'Petugas Dansos', 'slug' => 'dansos'],
        ['name' => 'Bendahara', 'slug' => 'bendahara'],
        ['name' => 'Tata Usaha', 'slug' => 'tata-usaha'],
        ['name' => 'Petugas Laporan', 'slug' => 'petugas-laporan'],
        ['name' => 'Anggota', 'slug' => 'anggota'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $admin = User::create([
            'name' => 'Ketua Karang Taruna',
        'email' => 'ketua@abhipraya.com',
        'password' => Hash::make('ketua123'), // Ganti saat production
        'phone' => '081234567890',
        'is_active' => true,
        ]);

        $adminRole = Role::where('slug', 'super-admin') ->first();
        $admin->roles()->attach($adminRole->id);
    }
}
