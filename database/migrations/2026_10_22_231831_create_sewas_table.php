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
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyewa');
            $table->text('alamat');
            
            // Relasi ke tabel asets
            $table->foreignId('aset_id')->constrained('asets')->onDelete('cascade');
            
            $table->integer('jumlah_pinjam');
            $table->date('tanggal_sewa');
            
            // Status untuk melacak apakah barang sudah dikembalikan
            $table->enum('status', ['Disewa', 'Dikembalikan'])->default('Disewa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
