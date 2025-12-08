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
        Schema::create('document_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('letters')->onDelete('cascade');
            $table->string('sha256_hash', 64)->unique(); // SHA-256 hash (64 hex characters)
            $table->text('verification_url'); // Full URL untuk verifikasi
            $table->timestamp('issued_at'); // Kapan hash di-generate
            $table->timestamp('expires_at')->nullable(); // Masa berlaku (optional)
            $table->integer('verified_count')->default(0); // Berapa kali di-verify
            $table->timestamp('last_verified_at')->nullable(); // Terakhir di-verify kapan
            $table->string('last_verified_ip')->nullable(); // IP terakhir yang verify
            $table->timestamps();
            
            // Index untuk performance
            $table->index('sha256_hash');
            $table->index('letter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_verifications');
    }
};
