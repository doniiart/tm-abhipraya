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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->nullable()->constrained()->nullOnDelete(); // Dicatat pada kumpulan mana
            $table->foreignId('member_id')->constrained()->cascadeOnDelete(); // Anggota yang mengusulkan
            $table->string('title'); // Inti/Judul usulan
            $table->text('content'); // Penjelasan lengkap usulan
            $table->enum('status', ['new', 'discussed', 'approved', 'postponed', 'rejected', 'done'])->default('new');
            $table->foreignId('pic_id')->nullable()->constrained('users'); // Pengurus penanggung jawab tindak lanjut
            $table->date('target_date')->nullable(); // Target selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
