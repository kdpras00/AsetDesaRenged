<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letter->letterType->name }} - {{ $letter->user->name }}</title>
    <style>
        @page {
            margin: 0.5cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 2px;
            margin-bottom: 10px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 60px;
            height: auto;
        }
        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .header h3 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0 0 0;
        }
        .header p {
            font-size: 9pt;
            margin: 0;
            font-weight: bold;
        }
        .title {
            text-align: center;
            margin-bottom: 10px;
        }
        .title h4 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
        }
        .title p {
            margin: 2px 0 0 0;
            font-size: 11pt;
        }
        .content {
            text-align: justify;
        }
        .table-data {
            width: 100%;
            margin: 5px 0 5px 0;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 1px 0;
            font-size: 11pt;
        }
        .label-col {
            width: 200px;
        }
        .separator-col {
            width: 10px;
        }
        .signature {
            margin-top: 10px;
            width: 100%;
            text-align: right; 
        }
        .signature-box {
            display: inline-block;
            width: 250px; /* Adjusted width */
            text-align: center;
            float: right;
        }
        .empty-space {
            height: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
            @php
            // AUTOMATIC LOGO FINDER - Mencari di berbagai lokasi
            $logoPath = null;
            $logoPaths = [
                public_path('storage/images/logo-renged.png'),
                storage_path('app/public/images/logo-renged.png'),
                base_path('storage/images/logo-renged.png'),
                base_path('public/storage/images/logo-renged.png'),
                '/home/kure8737/public_html/storage/images/logo-renged.png',
                '/home/kure8737/asetdesarenged.my.id/storage/images/logo-renged.png',
            ];
            
            foreach ($logoPaths as $path) {
                if (file_exists($path)) {
                    $logoPath = $path;
                    break;
                }
            }
            
            $logoBase64 = '';
            if ($logoPath) {
                try {
                    $imageData = base64_encode(file_get_contents($logoPath));
                    $mimeType = mime_content_type($logoPath);
                    $logoBase64 = "data:{$mimeType};base64,{$imageData}";
                } catch (\Exception $e) {
                    // Jika gagal, logo tidak akan ditampilkan
                }
            }
        @endphp
        
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo Desa Renged">
        @endif

        <h2>PEMERINTAH KABUPATEN TANGERANG</h2>
        <h3>KECAMATAN KRESEK</h3>
        <h1>DESA RENGED</h1>
        <p>Sekretariat : Jl. Kp. Solokan Rt. 012/004 Desa Renged Kecamatan Kresek</p>
        <p>Kabupaten Tangerang Provinsi Banten Kode Pos 15620</p>
    </div>

    <div class="title">
        <h4>SURAT KETERANGAN KEMATIAN</h4>
        @php
            $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
        @endphp
        <p>Nomor : {{ $letter->letter_number ?? '.......' }}</p>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan dibawah ini Kepala Desa Renged Kecamatan Kresek Kabupaten Tangerang, Menerangkan dengan ini sesungguhnya bahwa :
        </p>

        @php
            $data = $letter->data ?? [];
        @endphp

        <table class="table-data">
            <tr>
                <td class="label-col">Nama</td>
                <td class="separator-col">:</td>
                <td><strong>{{ strtoupper($data['deceased_name'] ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">NIK</td>
                <td class="separator-col">:</td>
                <td>{{ $data['deceased_nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">No KK</td>
                <td class="separator-col">:</td>
                <td>{{ $data['deceased_kk'] ?? $letter->user->kk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tempat/Tgal Lahir</td>
                <td class="separator-col">:</td>
                <td>{{ $data['deceased_birth_place'] ?? '-' }}, {{ isset($data['deceased_birth_date']) ? \Carbon\Carbon::parse($data['deceased_birth_date'])->format('d-m-Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Umur</td>
                <td class="separator-col">:</td>
                <td>{{ $data['deceased_age'] ?? '-' }} Tahun</td>
            </tr>
            <tr>
                <td class="label-col">Alamat Terakhir</td>
                <td class="separator-col">:</td>
                <td>{{ $data['deceased_address'] ?? '-' }}</td>
            </tr>
        </table>
        
        <div class="empty-space"></div>

        <p>Telah meninggal dunia pada</p>
        <table class="table-data">
            <tr>
                <td class="label-col">Hari</td>
                <td class="separator-col">:</td>
                <td>{{ strtoupper($data['death_day'] ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal</td>
                <td class="separator-col">:</td>
                <td>{{ isset($data['death_date']) ? \Carbon\Carbon::parse($data['death_date'])->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Meninggal di</td>
                <td class="separator-col">:</td>
                <td>{{ $data['death_place'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Disebabkan karena</td>
                <td class="separator-col">:</td>
                <td>{{ $data['death_cause'] ?? '-' }}</td>
            </tr>
        </table>

        <div class="empty-space"></div>

        <p>Yang melapor</p>
        <table class="table-data">
             <tr>
                <td class="label-col">Nama</td>
                <td class="separator-col">:</td>
                <td>{{ strtoupper($letter->user->name) }}</td>
            </tr>
             <tr>
                <td class="label-col">Hubungan dengan yang meninggal</td>
                <td class="separator-col">:</td>
                <td>{{ $data['reporter_relationship'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin-top: 15px;">
            Demikian Surat Keterangan ini kami buat dengan sesungguhnya, untuk dapat diketahui dan dipergunakan sebagaimana mestinya.
        </p>

        <div class="signature">
            <div class="signature-box">
                <p>Renged, {{ $date->translatedFormat('d F Y') }}<br>
                Kepala Desa Renged</p>
                
                <div style="margin: 10px auto;">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                        <!-- QR Code Logic same as SKCK -->
                         <img src="data:image/svg+xml;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                        <br>
                    @else
                        <br><br><br><br>
                    @endif
                </div>
                
                <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">
                    {{ $letter->kepalaDesa ? $letter->kepalaDesa->name : 'WAWAN' }}
                </p>
            </div>
        </div>
        <div style="font-size: 10px; color: #555; margin-top: 20px; font-style: italic;">
            Dokumen ini dicetak pada sistem digital pada tanggal {{ now()->translatedFormat('d F Y') }} sehingga tidak diperlukan tanda tangan basah.
        </div>
    </div>
</body>
</html>
