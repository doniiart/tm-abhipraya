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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']); // Pemasukan atau Pengeluaran
            $table->decimal('amount', 12, 2); // Nominal uang
            $table->string('category'); // Contoh: Iuran Bulanan, Pembelian Alat, Konsumsi
            $table->date('date');
            $table->text('description');
            $table->string('proof_file')->nullable(); // File/foto nota bukti bayar
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('social_fund_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 12, 2);
            $table->string('source_or_target'); // Sumbangan dari siapa / disalurkan ke siapa
            $table->date('date');
            $table->text('description');
            $table->string('proof_file')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_fund_transactions');
        Schema::dropIfExists('financial_transactions');
    }
};
