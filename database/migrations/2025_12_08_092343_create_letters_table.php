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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pemohon
            $table->foreignId('operator_id')->nullable()->constrained('users')->onDelete('set null'); // Operator yang proses
            $table->foreignId('kepala_desa_id')->nullable()->constrained('users')->onDelete('set null'); // Kepala Desa yang verify
            $table->foreignId('letter_type_id')->constrained('letter_types')->onDelete('cascade');
            $table->string('letter_number')->unique()->nullable(); // Nomor surat setelah diproses
            $table->text('purpose'); // Keperluan
            $table->date('request_date'); // Tanggal pengajuan
            $table->date('process_date')->nullable(); // Tanggal diproses operator
            $table->date('approved_date')->nullable(); // Tanggal di-approve kepala desa
            $table->enum('status', ['pending', 'processed', 'verified', 'rejected'])->default('pending');
            $table->string('qr_code')->nullable(); // Path ke QR code image
            $table->string('verification_code')->unique()->nullable(); // Kode unik untuk verifikasi
            $table->text('operator_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('attachment')->nullable(); // File lampiran persyaratan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
