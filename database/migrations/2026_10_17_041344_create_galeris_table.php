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
        Schema::create('galeris', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('kategori'); // Untuk menyimpan: kumpulan, sosial, atau pemuda
        $table->text('deskripsi');
        $table->string('foto'); // Untuk menyimpan nama file gambar
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Mencatat siapa yang mengupload
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
