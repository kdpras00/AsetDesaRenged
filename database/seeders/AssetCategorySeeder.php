<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kendaraan',
                'description' => 'Kendaraan dinas dan operasional desa',
            ],
            [
                'name' => 'Peralatan Kantor',
                'description' => 'Peralatan kantor dan administrasi',
            ],
            [
                'name' => 'Peralatan Pertanian',
                'description' => 'Alat-alat pertanian untuk keperluan warga',
            ],
            [
                'name' => 'Peralatan Acara',
                'description' => 'Tenda, kursi, meja, dan peralatan acara',
            ],
            [
                'name' => 'Peralatan Olahraga',
                'description' => 'Peralatan olahraga untuk kegiatan warga',
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Peralatan elektronik seperti sound system, proyektor, dll',
            ],
        ];

        foreach ($categories as $category) {
            AssetCategory::create($category);
        }
    }
}
