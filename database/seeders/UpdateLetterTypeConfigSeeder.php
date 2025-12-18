<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateLetterTypeConfigSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            'SKCK' => [
                'match' => 'skck', 
                'slug' => 'SKCK',
                'code' => '331', // Approximated based on context if not provided
                'config' => [
                    'letter_number_prefix' => 'SKCK',
                    'validation_rules' => [],
                    'fields' => [],
                    'pdf_view' => 'pdf.skck'
                ]
            ],
            'Kematian' => [
                'match' => 'kematian',
                'slug' => 'SKM',
                'code' => '472.12', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SKM',
                    'validation_rules' => [
                        'deceased_name' => 'required|string|max:255',
                        'deceased_nik' => 'required|numeric|digits:16',
                        'deceased_kk' => 'nullable|string|max:20',
                        'deceased_birth_place' => 'required|string|max:100',
                        'deceased_birth_date' => 'required|date',
                        'deceased_age' => 'required|integer',
                        'deceased_address' => 'required|string',
                        'death_day' => 'required|string',
                        'death_date' => 'required|date',
                        'death_place' => 'required|string',
                        'death_cause' => 'required|string',
                        'reporter_relationship' => 'required|string',
                    ],
                    'fields' => [
                        'deceased_name', 'deceased_nik', 'deceased_kk', 
                        'deceased_birth_place', 'deceased_birth_date', 'deceased_age', 
                        'deceased_address', 'death_day', 'death_date', 
                        'death_place', 'death_cause', 'reporter_relationship'
                    ],
                    'pdf_view' => 'pdf.surat-kematian'
                ]
            ],
            'Usaha' => [
                'match' => 'usaha',
                'slug' => 'SKU',
                'code' => '511.3', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SKU',
                    'validation_rules' => [
                        'business_name' => 'required|string|max:255',
                        'business_type' => 'required|string|max:255',
                        'business_address' => 'required|string|max:500',
                    ],
                    'fields' => ['business_name', 'business_type', 'business_address'],
                     'pdf_view' => 'pdf.surat-keterangan-usaha'
                ]
            ],
            'Cuti' => [
                'match' => 'cuti',
                'slug' => 'SIC',
                'code' => '800', // Common for Personnel/Cuti
                'config' => [
                    'letter_number_prefix' => 'SIC',
                    'validation_rules' => [
                        'company_name' => 'required|string|max:255',
                        'leave_day' => 'required|string|max:20',
                        'leave_date' => 'required|date',
                        'leave_purpose' => 'required|string|max:500',
                        'child_name' => 'nullable|string|max:255',
                    ],
                    'fields' => ['company_name', 'leave_day', 'leave_date', 'leave_purpose', 'child_name'],
                    'pdf_view' => 'pdf.surat-keterangan-ijin-cuti'
                ]
            ],
            'Tidak Bekerja' => [
                'match' => 'tidak bekerja',
                'slug' => 'SKTB',
                'code' => '470',
                'config' => [
                    'letter_number_prefix' => 'SKTB',
                    'validation_rules' => [
                        'marital_status' => 'required|string|max:50',
                    ],
                    'fields' => ['marital_status'],
                     'pdf_view' => 'pdf.surat-keterangan-tidak-bekerja'
                ]
            ],
            'Tidak Memiliki Ijazah' => [
                'match' => 'tidak memiliki ijazah',
                'slug' => 'SKTMI',
                'code' => '420', // Education
                'config' => [
                    'letter_number_prefix' => 'SKTMI',
                    'validation_rules' => [
                        'marital_status' => 'required|string|max:50',
                    ],
                    'fields' => ['marital_status'],
                     'pdf_view' => 'pdf.surat-keterangan-tidak-memiliki-ijazah'
                ]
            ],
             'Kelahiran' => [
                'match' => 'kelahiran',
                'slug' => 'SKL',
                'code' => '472.11', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SKL',
                    'validation_rules' => [
                        'child_name' => 'required|string|max:255',
                        'child_nik' => 'required|numeric|digits:16',
                        'child_gender' => 'required|in:L,P',
                        'child_birth_place' => 'required|string|max:255',
                        'child_birth_date' => 'required|date',
                        'child_address' => 'required|string|max:500',
                        'father_name' => 'required|string|max:255',
                        'father_birth_place' => 'required|string|max:255',
                        'father_birth_date' => 'required|date',
                        'father_address' => 'required|string|max:500',
                        'mother_name' => 'required|string|max:255',
                        'mother_birth_place' => 'required|string|max:255',
                        'mother_birth_date' => 'required|date',
                        'mother_address' => 'required|string|max:500',
                    ],
                    'fields' => [
                        'child_name', 'child_nik', 'child_gender', 'child_birth_place', 'child_birth_date', 'child_address',
                        'father_name', 'father_birth_place', 'father_birth_date', 'father_address',
                        'mother_name', 'mother_birth_place', 'mother_birth_date', 'mother_address',
                    ],
                     'pdf_view' => 'pdf.surat-keterangan-kelahiran'
                ]
            ],
            'Domisili' => [
                'match' => 'domisili',
                'slug' => 'SKD',
                'code' => '146', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SKD', // Short Code
                    'validation_rules' => [
                         'alamat_domisili' => 'required|string|max:500',
                    ],
                    'fields' => ['alamat_domisili'],
                     'pdf_view' => 'pdf.surat-keterangan-domisili'
                ]
            ],
            'Keramaian' => [
                'match' => 'keramaian',
                'slug' => 'SIK',
                'code' => '331.5', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SIK',
                    'validation_rules' => [
                        'event_day' => 'required|string|max:20',
                        'event_date' => 'required|date',
                        'event_time' => 'required|string|max:50',
                        'event_place' => 'required|string|max:255',
                        'event_name' => 'required|string|max:255',
                        'event_entertainment' => 'nullable|string|max:255',
                    ],
                    'fields' => [
                         'event_day', 'event_date', 'event_time', 'event_place', 'event_name', 'event_entertainment'
                    ],
                     'pdf_view' => 'pdf.surat-keterangan-ijin-keramaian'
                ]
            ],
            'Tidak Mampu' => [
                'match' => 'tidak mampu',
                'slug' => 'SKTM',
                'code' => '401', // Client Request
                'config' => [
                    'letter_number_prefix' => 'SKTM',
                    'validation_rules' => [
                        'father_name' => 'required|string|max:255',
                        'father_nik' => 'required|numeric|digits:16',
                        'father_job' => 'required|string|max:255',
                        'father_address' => 'required|string|max:500',
                        'mother_name' => 'required|string|max:255',
                        'mother_nik' => 'required|numeric|digits:16',
                        'mother_job' => 'required|string|max:255',
                        'mother_address' => 'required|string|max:500',
                    ],
                    'fields' => [
                        'father_name', 'father_nik', 'father_job', 'father_address',
                        'mother_name', 'mother_nik', 'mother_job', 'mother_address',
                    ],
                     'pdf_view' => 'pdf.surat-keterangan-tidak-mampu'
                ]
            ],
            'Penghasilan' => [
                'match' => 'penghasilan',
                'slug' => 'SKP',
                'code' => '401', // Same as SKTM usually
                'config' => [
                    'letter_number_prefix' => 'SKP',
                    'validation_rules' => [], 
                    'fields' => [],
                     'pdf_view' => 'pdf.surat-keterangan-penghasilan'
                ]
            ],
            'KTP' => [
                'match' => 'ktp',
                'slug' => 'KTP',
                'config' => [
                     'letter_number_prefix' => 'KTP',
                     'validation_rules' => [
                        'ktp_type' => 'required|in:Baru,Perpanjangan,Penggantian',
                    ],
                    'fields' => ['ktp_type'],
                     'pdf_view' => 'excel' 
                ]
            ]
        ];

        $types = DB::table('letter_types')->get();

        foreach ($types as $type) {
            $name = strtolower($type->name);
            foreach ($configs as $key => $data) {
                if (str_contains($name, $data['match'])) {
                    $updateData = [
                        'slug' => $data['slug'],
                        'form_config' => json_encode($data['config'])
                    ];
                    
                    if (isset($data['code'])) {
                        $updateData['code'] = $data['code'];
                    }

                    DB::table('letter_types')->where('id', $type->id)->update($updateData);
                    break;
                }
            }
        }
    }
}
