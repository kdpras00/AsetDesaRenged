<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Desa
        User::create([
            'name' => 'Bapak Kepala Desa',
            'email' => 'kepaladesa@renged.id',
            'password' => Hash::make('password'),
            'role' => 'kepala_desa',
            'phone' => '081234567890',
            'address' => 'Desa Renged, Kecamatan Kresek',
        ]);

        // Operator Desa
        User::create([
            'name' => 'Operator Desa Renged',
            'email' => 'operator@renged.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'phone' => '081234567891',
            'address' => 'Desa Renged, Kecamatan Kresek',
        ]);

        // Sample Warga 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'nik' => '3603010101900001',
            'phone' => '081234567892',
            'address' => 'Jl. Merdeka No. 1',
            'rt_rw' => '001/001',
        ]);

        // Sample Warga 2
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'nik' => '3603010101920002',
            'phone' => '081234567893',
            'address' => 'Jl. Pahlawan No. 5',
            'rt_rw' => '002/001',
        ]);

        // Sample Warga 3
        User::create([
            'name' => 'Ahmad Yani',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'nik' => '3603010101950003',
            'phone' => '081234567894',
            'address' => 'Jl. Sudirman No. 10',
            'rt_rw' => '003/002',
        ]);
    }
}
