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
        Schema::table('setting_webs', function (Blueprint $table) {
        $table->string('nama_organisasi')->nullable()->after('stat_sosial');
        $table->text('deskripsi')->nullable()->after('nama_organisasi');
        $table->string('tahun_berdiri')->nullable()->after('deskripsi');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting_webs', function (Blueprint $table) {
        $table->dropColumn(['nama_organisasi', 'deskripsi', 'tahun_berdiri']);
    });
    }
};
