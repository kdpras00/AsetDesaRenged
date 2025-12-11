<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letter->letterType->name }} - {{ $letter->user->name }}</title>
    <style>
        @page {
            margin: 1cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
            position: relative;
            min-height: 85px;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
            height: auto;
        }
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
            line-height: 1.2;
        }
        .header h3 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
            line-height: 1.2;
        }
        .header p {
            font-size: 10pt;
            margin: 2px 0;
            line-height: 1.2;
        }
        .title {
            text-align: center;
            margin-bottom: 15px;
        }
        .title h4 {
            margin: 5px 0;
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
        }
        .title p {
            margin: 5px 0;
            font-size: 11pt;
        }
        .content {
            text-align: justify;
        }
        .content > p {
            margin: 10px 0;
        }
        .table-data {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 3px 0;
            font-size: 11pt;
        }
        .table-data td:nth-child(1) {
            width: 30px;
        }
        .table-data td:nth-child(2) {
            width: 150px;
        }
        .table-data td:nth-child(3) {
            width: 10px;
        }
        .points {
            margin: 15px 0 15px 30px;
        }
        .points p {
            margin: 5px 0;
            font-style: italic;
            font-weight: bold;
        }
        .signature {
            margin-top: 30px;
            width: 100%;
        }
        .signature-box {
            display: inline-block;
            width: 220px;
            text-align: center;
            float: right;
        }
        .signature-box p {
            margin: 5px 0;
            line-height: 1.3;
        }
        .qr-container {
            margin: 15px auto 10px;
            min-height: 90px;
        }
        .signature-name {
            text-decoration: underline;
            font-weight: bold;
            margin-top: 5px;
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
        <h2>DESA RENGED</h2>
        <p>Jl. Raya Kresek Km. 03 Kp. Renged RT. 003/001 Kode Pos 15620</p>
        <p>Email: pemdesrenged@gmail.com</p>
    </div>

    @php
        $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
    @endphp

    <div class="title">
        <h4>SURAT PENGANTAR KETERANGAN CATATAN KEPOLISIAN (SKCK)</h4>
        <p>Nomor : 470 / {{ $letter->letter_number ?? '.......' }} / Ds.Rgd / {{ $date->format('Y') }}</p>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Renged Kecamatan Kresek Kabupaten Tangerang, menerangkan dengan sesungguhnya bahwa :
        </p>

        <table class="table-data">
            <tr>
                <td style="width: 30px;">1.</td>
                <td style="width: 130px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ strtoupper($letter->user->name) }}</strong></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $letter->user->nik }}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $letter->user->gender == 'L' ? 'Laki-laki' : ($letter->user->gender == 'P' ? 'Perempuan' : '-') }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Tempat/Tgl.Lahir</td>
                <td>:</td>
                <td>{{ $letter->user->birth_place ?? '-' }}, {{ $letter->user->birth_date ? \Carbon\Carbon::parse($letter->user->birth_date)->translatedFormat('d-m-Y') : '-' }}</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Warganegara</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $letter->user->religion ?? '-' }}</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $letter->user->job ?? '-' }}</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $letter->user->address }}</td>
            </tr>
        </table>

        <p>
            Nama tersebut diatas adalah benar warga yang berdomisili di Desa Renged, menurut sepengamatan kami hingga surat keterangan ini dibuat, yang bersangkutan adalah :
        </p>

        <div class="points">
            <p>a. Berkelakuan Baik</p>
            <p>b. Tidak pernah terlibat organisasi politik terlarang</p>
            <p>c. Tidak sedang dalam perkara pidana</p>
        </div>

        <p>
            Demikian keterangan ini dibuat dengan sesungguhnya untuk dapat diketahui semestinya dan kepada pihak terkait dimohon kelanjutannya agar yang bersangkutan dapat dibuatkan Surat Keterangan Catatan Kepolisian (SKCK) dengan maksud tujuan <strong>"{{ $letter->purpose }}"</strong>.
        </p>

        <div class="signature">
            <div class="signature-box">
                <p>Renged, {{ $date->translatedFormat('d F Y') }}<br>
                Kepala Desa Renged</p>
                
                <div class="qr-container">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                        <img src="data:image/svg+xml;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                        <br>
                        <span style="font-size: 8pt; color: #555;"><i>Ditandatangani Secara Elektronik</i></span>
                    @else
                        <br><br><br>
                    @endif
                </div>
                
                <p class="signature-name">
                    {{ $letter->kepalaDesa ? $letter->kepalaDesa->name : 'APUD MAHFUD, S.Pd' }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>