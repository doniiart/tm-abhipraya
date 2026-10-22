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
        Schema::create('kompensasis', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal'); // Untuk mencatat kapan dana masuk
        $table->string('sumber_dana'); // Keterangan (Contoh: "Dana CSR PT Bumi", "Donasi Hamba Allah")
        $table->integer('nominal'); // Jumlah uang yang masuk
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompensasis');
    }
};
