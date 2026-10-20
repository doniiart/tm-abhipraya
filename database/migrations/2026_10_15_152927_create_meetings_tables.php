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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: Kumpulan Rutin Bulan Oktober
            $table->date('date'); // Tanggal masehi
            $table->string('javanese_date')->nullable(); // Tanggal Jawa/Pasaran (misal: Minggu Pon)
            $table->string('location'); // Lokasi tempat kumpulan
            $table->string('host_name'); // Nama tuan rumah
            $table->enum('status', ['draft', 'published', 'finished'])->default('draft');
            $table->foreignId('created_by')->constrained('users'); // Pengurus yang buat jadwal
            $table->timestamps();
        });

        Schema::create('meeting_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->string('session_name'); // Misal: Pembukaan, Latihan Diplomasi, Laporan Bendahara
            $table->string('pic_name')->nullable(); // Petugas / Penanggung jawab sesi
            $table->text('notes')->nullable(); // Hasil notulen / catatan sesi ini
            $table->integer('order_no')->default(0); // Urutan acara (1, 2, 3...)
            $table->timestamps();
        });

        Schema::create('meeting_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['present', 'absent', 'excused'])->default('present'); // Hadir, Alfa, Izin
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_attendances');
        Schema::dropIfExists('meeting_agendas');
        Schema::dropIfExists('meetings');
    }
};
