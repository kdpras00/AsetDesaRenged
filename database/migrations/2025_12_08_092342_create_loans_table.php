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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Peminjam
            $table->foreignId('operator_id')->nullable()->constrained('users')->onDelete('set null'); // Operator yang approve
            $table->date('loan_date');
            $table->date('return_date'); // Tanggal rencana kembali
            $table->date('actual_return_date')->nullable(); // Tanggal aktual kembali
            $table->integer('quantity')->default(1);
            $table->text('purpose'); // Tujuan peminjaman
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->text('operator_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
