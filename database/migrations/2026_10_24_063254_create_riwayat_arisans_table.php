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
        Schema::create('riwayat_arisans', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal'); // Tanggal pelaksanaan
        $table->string('tempat')->nullable(); // Rumah siapa yang ketempatan
        
        // Pemasukan
        $table->integer('pemasukan_candi')->default(0);
        $table->integer('pemasukan_gunung')->default(0);
        $table->integer('total_kas_awal')->default(0); 
        
        // Pemotongan & Defisit
        $table->integer('potongan_dansos')->default(25000);
        $table->integer('tutup_defisit_lalu')->default(0); // Ngambil dari kekurangan bulan kemarin
        
        // Hasil Akhir
        $table->integer('arisan_mendapatkan')->default(0); // Uang bersih yang dibawa tuan rumah
        $table->integer('target_hak_tuan_rumah')->default(290000); // Target/hak idealnya
        $table->integer('masih_kurang')->default(0); // Defisit baru yang diwariskan ke bulan depan
        
        $table->string('status')->default('selesai'); // aktif / selesai
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_arisans');
    }
};
