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
        Schema::create('rekap_pertemuans', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_lokasi')->nullable();
            $table->string('agenda_nama')->nullable();
            $table->string('agenda_tanggal')->nullable();
            $table->integer('total_candi')->default(0);
            $table->integer('total_gunung')->default(0);
            $table->integer('total_arisan')->default(0);
            $table->integer('potongan_dansos')->default(0);
            $table->text('notulensi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_pertemuans');
    }
};
