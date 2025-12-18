<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add 'code' column to letter_types
        Schema::table('letter_types', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });

        // 2. Modify loans status enum to include 'returning'
        // DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'returned', 'returning') NOT NULL DEFAULT 'pending'");
        // Since we are using SQLite or MySQL? User has XAMPP, so MySQL.
        // Let's use raw statement for MySQL.
        DB::statement("ALTER TABLE loans CHANGE COLUMN status status ENUM('pending', 'approved', 'rejected', 'returned', 'returning') NOT NULL DEFAULT 'pending'");

        // 3. Update existing Letter Types with Codes and New Names
        $types = [
            'SKCK' => ['code' => '470', 'name' => 'Surat Pengantar SKCK'],
            'Surat Kematian' => ['code' => '472.12', 'name' => 'Surat Pengantar Kematian'],
            'Surat Keterangan Usaha' => ['code' => '503', 'name' => 'Surat Pengantar Keterangan Usaha'],
            'Surat Keterangan Ijin Cuti' => ['code' => '800', 'name' => 'Surat Pengantar Ijin Cuti'],
            'Surat Keterangan Tidak Bekerja' => ['code' => '470', 'name' => 'Surat Pengantar Keterangan Tidak Bekerja'],
            'Surat Keterangan Tidak Memiliki Ijazah' => ['code' => '420', 'name' => 'Surat Pengantar Keterangan Tidak Memiliki Ijazah'],
            'Surat Keterangan Kelahiran' => ['code' => '472.11', 'name' => 'Surat Pengantar Kelahiran'],
            'Surat Keterangan Ijin Keramaian' => ['code' => '300', 'name' => 'Surat Pengantar Ijin Keramaian'],
            'Surat Keterangan Domisili' => ['code' => '470', 'name' => 'Surat Pengantar Keterangan Domisili'],
            'Surat Keterangan Tidak Mampu' => ['code' => '400', 'name' => 'Surat Pengantar Keterangan Tidak Mampu'], // SKTM usually 401/460 but let's use 400 or keep it simple
            'Surat Keterangan Penghasilan' => ['code' => '470', 'name' => 'Surat Pengantar Keterangan Penghasilan'],
            'Formulir Permohonan KTP' => ['code' => '471.13', 'name' => 'Surat Pengantar Permohonan KTP'], 
        ];

        // We need to be careful with exact name matching. Let's try to match loosely or just update by ID if we knew them, but name is safer if seeded correctly.
        // Or better, we can iterate all and map based on keywords.
        
        $allTypes = DB::table('letter_types')->get();
        foreach ($allTypes as $type) {
            $newCode = '470'; // Default
            $newName = $type->name;

            if (str_contains(strtolower($type->name), 'skck')) {
                $newCode = '470';
                $newName = 'Surat Pengantar SKCK';
            } elseif (str_contains(strtolower($type->name), 'kematian')) {
                $newCode = '474.3';
                $newName = 'Surat Pengantar Kematian';
            } elseif (str_contains(strtolower($type->name), 'usaha')) {
                $newCode = '503';
                $newName = 'Surat Pengantar Keterangan Usaha';
            } elseif (str_contains(strtolower($type->name), 'cuti')) {
                $newCode = '850';
                $newName = 'Surat Pengantar Ijin Cuti';
            } elseif (str_contains(strtolower($type->name), 'tidak bekerja')) {
                $newCode = '470';
                $newName = 'Surat Pengantar Keterangan Tidak Bekerja';
            } elseif (str_contains(strtolower($type->name), 'ijazah')) {
                $newCode = '421';
                $newName = 'Surat Pengantar Keterangan Tidak Memiliki Ijazah';
            } elseif (str_contains(strtolower($type->name), 'kelahiran')) {
                $newCode = '474.1';
                $newName = 'Surat Pengantar Kelahiran';
            } elseif (str_contains(strtolower($type->name), 'keramaian')) {
                $newCode = '331';
                $newName = 'Surat Pengantar Ijin Keramaian';
            } elseif (str_contains(strtolower($type->name), 'domisili')) {
                $newCode = '470';
                $newName = 'Surat Pengantar Keterangan Domisili';
            } elseif (str_contains(strtolower($type->name), 'tidak mampu') || str_contains(strtolower($type->name), 'sktm')) {
                $newCode = '401';
                $newName = 'Surat Pengantar Keterangan Tidak Mampu';
            } elseif (str_contains(strtolower($type->name), 'penghasilan')) {
                $newCode = '470';
                $newName = 'Surat Pengantar Keterangan Penghasilan';
            } elseif (str_contains(strtolower($type->name), 'ktp')) {
                $newCode = '471.13';
                $newName = 'Formulir Permohonan KTP'; // Keep specific name but add code
            }

            // Ensure "Surat Pengantar" prefix if not KTP
            if (!str_contains($newName, 'Surat Pengantar') && !str_contains($newName, 'Formulir')) {
               $newName = 'Surat Pengantar ' . $newName;
            }

            DB::table('letter_types')->where('id', $type->id)->update([
                'code' => $newCode,
                'name' => $newName
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_types', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        // Reverting enum is tricky without knowing exact previous state, but we can try removing 'returning'
        DB::statement("ALTER TABLE loans CHANGE COLUMN status status ENUM('pending', 'approved', 'rejected', 'returned') NOT NULL DEFAULT 'pending'");
    }
};
