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
        Schema::create('pengeluaran_dansos', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['Sakit', 'Takziah']);
            $table->string('keterangan'); // Contoh: Mbah Warno (RT 23) atau Alm. Pak Budi
            $table->bigInteger('nominal');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_dansos');
    }
};
