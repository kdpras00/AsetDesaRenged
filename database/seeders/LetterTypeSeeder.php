<?php

namespace Database\Seeders;

use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    public function run(): void
    {
        $letterTypes = [
            [
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan tempat tinggal',
                'requirements' => ['KTP', 'KK'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'description' => 'Surat keterangan untuk warga tidak mampu',
                'requirements' => ['KTP', 'KK', 'Surat Pernyataan'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'description' => 'Surat keterangan untuk usaha',
                'requirements' => ['KTP', 'KK', 'Foto Usaha'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Pengantar KTP',
                'description' => 'Surat pengantar untuk pembuatan KTP',
                'requirements' => ['KK', 'Akta Kelahiran'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'description' => 'Surat keterangan kelahiran',
                'requirements' => ['KTP Orang Tua', 'KK', 'Surat Keterangan Lahir dari Bidan/RS'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'description' => 'Surat keterangan kematian',
                'requirements' => ['KTP Almarhum', 'KK', 'Surat Keterangan Kematian dari RS/Puskesmas'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Keterangan Penghasilan',
                'description' => 'Surat keterangan penghasilan',
                'requirements' => ['KTP', 'KK'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek menerangkan bahwa...',
            ],
            [
                'name' => 'Surat Izin Keramaian',
                'description' => 'Surat izin untuk acara/keramaian',
                'requirements' => ['KTP Penanggungjawab', 'Proposal Kegiatan'],
                'template' => 'Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek memberikan izin bahwa...',
            ],
        ];

        foreach ($letterTypes as $type) {
            LetterType::create($type);
        }
    }
}
