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
            font-weight: normal; 
        }
         .header p a {
            color: blue;
            text-decoration: underline;
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
            margin: 5px 0 5px 10px;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 1px 0;
            font-size: 11pt;
        }
        .label-col {
            width: 150px;
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
            width: 250px;
            text-align: center;
            float: right;
            margin-right: -10px; 
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
        <p>Jln. Kp. Solokan Rt. 12/004 Desa Renged Kec. Kresek kab. Tangerang – Banten kode pos 15620</p>
        <p>Email:<a href="mailto:desa9@websitedesa.info">desa9@websitedesa.info</a> Telp: 083877674662 - 083877674662</p>
    </div>

        @php
            $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
        @endphp

    <div class="title">
        <h4>SURAT KETERANGAN TIDAK BEKERJA</h4>
        <p>Nomor : {{ $letter->letter_number ?? '.......' }}</p>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan dibawah ini Kepala Desa Renged Kecamatan Kresek Kabupaten Tangerang, menerangkan dengan sesungguhnya bahwa :
        </p>

        @php
            $data = $letter->data ?? [];
        @endphp

        <table class="table-data" style="margin-left: 30px;">
            <tr>
                <td class="label-col">Nama</td>
                <td class="separator-col">:</td>
                <td><strong>{{ strtoupper($letter->user->name) }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">NIK</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->nik }}</td>
            </tr>
            <tr>
                <td class="label-col">Jenis kelamin</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tempat/Tgl.Lahir</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->birth_place }}, {{ \Carbon\Carbon::parse($letter->user->birth_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Warganegara</td>
                <td class="separator-col">:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td class="label-col">Agama</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->religion ?? 'Islam' }}</td>
            </tr>
            
            <tr>
                <td class="label-col">Status Perkawinan</td>
                <td class="separator-col">:</td>
                <td>{{ $data['marital_status'] ?? '-' }}</td>
            </tr>
            
            <tr>
                <td class="label-col">Pekerjaan</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->job ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->address }}</td>
            </tr>
        </table>
        
        <p>
            Nama tersebut diatas adalah benar Penduduk Desa Renged Kec.Kresek Kab.Tangerang. Berdasarkan keterangan dari RT/RW setempat, dan pengakuan yang bersangkutan bahwa benar pada saat ini <u><strong>BELUM/TIDAK BEKERJA</strong></u>.
        </p>

        <p style="margin-top: 15px;">
            Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat diketahui semestinya. atas kerjasamanya kami ucapkan terimakasih.
        </p>

        <div class="signature">
             <div class="signature-box">
                <p>Renged, {{ $date->translatedFormat('d F Y') }}<br>
                Kepala Desa Renged</p>
                
                <div style="margin: 10px auto;">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                         <img src="data:image/svg+xml;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                        <br>
                    @else
                        <br><br><br><br>
                    @endif
                </div>
                
                <p style="text-decoration: underline; font-weight: bold;">
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
