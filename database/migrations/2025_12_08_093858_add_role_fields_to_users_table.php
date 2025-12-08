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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['operator', 'warga', 'kepala_desa'])->default('warga')->after('email');
            $table->string('nik', 16)->unique()->nullable()->after('role'); // NIK untuk warga
            $table->string('phone', 15)->nullable()->after('nik');
            $table->text('address')->nullable()->after('phone');
            $table->string('rt_rw', 10)->nullable()->after('address'); // Format: 001/002
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik', 'phone', 'address', 'rt_rw']);
        });
    }
};
