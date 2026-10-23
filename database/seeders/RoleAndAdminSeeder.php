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
        ['name' => 'Petugas Persewaan','slug' => 'persewaan'],
        ['name' => 'Anggota', 'slug' => 'anggota'],
        ];

        foreach ($roles as $role) {
        Role::updateOrCreate(
            ['slug' => $role['slug']],
            ['name' => $role['name']]
        );
    }

        $admin = User::updateOrCreate(
        ['email' => 'ketua@abhipraya.com'], 
        [
            'name' => 'Ketua Karang Taruna',
            'password' => Hash::make('ketua123'),
            'phone' => '081234567890',
            'is_active' => true,
        ]
    );

        $adminRole = Role::where('slug', 'super-admin') ->first();
        $admin->roles()->attach($adminRole->id);
    }
}
