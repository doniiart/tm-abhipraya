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
        Schema::create('setting_webs', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom-kolom ini
            $table->string('agenda_nama')->nullable();
            $table->string('agenda_lokasi')->nullable();
            $table->string('agenda_waktu')->nullable();
            $table->string('agenda_tanggal')->nullable();
            $table->string('agenda_bulan')->nullable();
            $table->dateTime('agenda_target_countdown')->nullable();
            
            $table->string('stat_anggota')->nullable();
            $table->string('stat_kas')->nullable();
            $table->string('stat_sosial')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_webs');
    }
};
