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
        Schema::create('laporan_sekretaris', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('agenda_id')->nullable(); // mengaitkan ke tabel agenda
        $table->text('usulan_saran')->nullable(); // satu satunya yang diketik manual oleh sekretaris

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_sekretaris');
    }
};
