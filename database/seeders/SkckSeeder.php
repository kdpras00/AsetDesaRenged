<?php

namespace Database\Seeders;

use App\Models\LetterType;
use Illuminate\Database\Seeder;

class SkckSeeder extends Seeder
{
    public function run(): void
    {
        LetterType::create([
            'name' => 'Surat Pengantar SKCK',
            'description' => 'Surat pengantar untuk pembuatan SKCK di Polsek/Polres',
            'requirements' => json_encode(['Fotocopy KTP', 'Fotocopy KK', 'Pengantar RT/RW']),
            'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
        ]);
    }
}
