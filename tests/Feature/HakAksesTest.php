<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HakAksesTest extends TestCase
{
    use RefreshDatabase;
    public function test_anggota_biasa_tidak_bisa_buka_halaman_keuangan()
    {
        // 1. Kita buat satu akun bohongan dengan peran "Anggota"
       $roleAnggota = Role::create([
            'name' => 'Anggota', 
            'slug' => 'anggota'
        ]);

        // 2. Buat akun bohongan dan tempelkan peran tersebut
        $user = User::factory()->create();
        $user->roles()->attach($roleAnggota->id);

        // 3. Simulasikan login
        $this->actingAs($user);

        // 4. Coba bobol masuk
        $response = $this->get('/admin/keuangan');

        // 5. Pastikan ditolak
        $response->assertStatus(403);
    }
}