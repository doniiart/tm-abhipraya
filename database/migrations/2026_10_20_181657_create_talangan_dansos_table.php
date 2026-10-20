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
        Schema::create('talangan_dansos', function (Blueprint $table) {
        $table->id();
        $table->string('keterangan'); // Contoh: Talangan untuk jenguk Pak Budi
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
        Schema::dropIfExists('talangan_dansos');
    }
};
