<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom rt_akses dengan pilihan '23', '24', atau 'all' (admin)
            // default('all') agar akun admin lama Anda tetap bisa akses semuanya
            $table->enum('rt_akses', ['23', '24', 'all'])->default('all')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rt_akses');
        });
    }
};
