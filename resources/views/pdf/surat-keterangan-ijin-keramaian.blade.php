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
            font-size: 10pt; /* Reduced for content density */
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
            font-size: 10pt;
        }
        .content {
            text-align: justify;
        }
        .table-data {
            width: 100%;
            margin: 2px 0 2px 10px;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 1px 0;
            font-size: 10pt;
        }
        .label-col {
            width: 140px;
        }
        .separator-col {
            width: 10px;
        }
        /* Signature Layout */
        .signature-container {
            margin-top: 10px;
            width: 100%;
            clear: both;
        }
        .signature-right {
            float: right;
            width: 250px;
            text-align: center;
            margin-bottom: 40px; /* Reduced */
        }
         .signature-bottom {
            width: 100%;
            clear: both;
            margin-top: 10px;
            display: table; 
        }
        .signature-column {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding-top: 10px;
        }
        
        .signature-name {
            margin-top: 40px; /* Reduced space */
            text-decoration: underline;
            font-weight: bold;
            text-transform: uppercase;
        }
        .signature-nrp {
            margin-top: 0px;
        }
         
        .qr-code-container {
             margin: 5px auto;
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
        <p>Jl.Kp.Solokan Rt.12/04 Kresek – Tangerang Kode Pos 15620</p>
        <p>Email:<a href="mailto:Desarenged9@gmail.com">Desarenged9@gmail.com</a> Blog:<a href="https://Infodesarenged.blogspot.com">https://Infodesarenged.blogspot.com</a></p>
    </div>

        @php
            $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
        @endphp

    <div class="title">
        <h4>SURAT KETERANGAN IJIN KERAMAIAN</h4>
        <p>Nomor : 331.5 / {{ $letter->letter_number ?? '.......' }} - Ds.Rgd / {{ \App\Helpers\Romawi::get($date->format('n')) }} / {{ $date->format('Y') }}</p>
    </div>

    <div class="content">
        <p>
            Pemerintah Desa Renged Kecamatan Kresek Kabupaten Tangerang, dalam rangka memenuhi Permohonan Ijin Rame-Rame dari :
        </p>

        @php
            $data = $letter->data ?? [];
        @endphp

        <table class="table-data" style="margin-left: 20px;">
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
                <td class="label-col">Tempat Tanggal/Lahir</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->birth_place ?? '-' }}, {{ $letter->user->birth_date ? \Carbon\Carbon::parse($letter->user->birth_date)->translatedFormat('d-m-Y') : '-' }}</td>
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
            
            <tr><td colspan="3" style="height: 10px;"></td></tr>

            <tr>
                <td class="label-col">Waktu Pelaksanaan</td>
                <td class="separator-col"></td>
                <td></td>
            </tr>
            <tr>
                <td class="label-col">Hari</td>
                <td class="separator-col">:</td>
                <td>{{ $data['event_day'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal</td>
                <td class="separator-col">:</td>
                <td>{{ isset($data['event_date']) ? \Carbon\Carbon::parse($data['event_date'])->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Pukul</td>
                <td class="separator-col">:</td>
                <td>{{ $data['event_time'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tempat</td>
                <td class="separator-col">:</td>
                <td>{{ $data['event_place'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Acara</td>
                <td class="separator-col">:</td>
                <td><strong>{{ isset($data['event_name']) ? strtoupper($data['event_name']) : '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Hiburan</td>
                <td class="separator-col">:</td>
                <td>{{ $data['event_entertainment'] ?? '-' }}</td>
            </tr>
        </table>
        
        <p>
            Dengan ini menerangkan bahwa nama diatas yang bertanggung jawab atas acara tersebut. pada Prinsipnya tidak keberatan atas Permohonan yang bersangkutan, dengan ketentuan sebagai berikut :
        </p>
        <ol>
            <li style="text-align: justify; margin-bottom: 5px;">
                <em>Pada Waktu dilaksanakan Rame- rame harus di sertai dengan ketentraman dan ketertiban dalam lingkungannya baik hubungan dengan tetangga , menghargai waktu-waktu ibadah dalam menciptakan kerukunan umat beragama maupun kebersihan lingkungan setelah selesai Rame-Rame.</em>
            </li>
            <li style="text-align: justify;">
                <em>Pada waktu di laksanankan rame-rame tidak di benarkan /dilarang melakukan hal-hal yang bertentangan dengan ketentuan yang berlaku adat istiadat bangsa.</em>
            </li>
        </ol>

        <div class="signature-container">
            <!-- Kepala Desa (Top Right) -->
            <div class="signature-right">
                <p>Renged, {{ $date->translatedFormat('d F Y') }}<br>
                KEPALA DESA RENGED</p>
                
                 <div class="qr-code-container">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                         <img src="data:image/svg+xml;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                    @else
                        <br><br><br>
                    @endif
                </div>

                <p class="signature-name">W A W A N</p>
            </div>

            <!-- Mengetahui Section (Bottom Left & Right) -->
             <div style="clear: both; text-align: center; font-weight: bold; width: 100%; margin-top: -20px; margin-bottom: 10px;">
                Mengetahui;
            </div>

            <div class="signature-bottom">
                 <div class="signature-column">
                    <strong>BINAMAS DESA RENGED</strong>
                    <br><br><br><br><br>
                    <div class="signature-name">AIPDA UCU MULYANA</div>
                    <div class="signature-nrp">NRP. 83100971</div>
                </div>
                <div class="signature-column">
                    <strong>BABINSA 2 DESA RENGED</strong>
                     <br><br><br><br><br>
                    <div class="signature-name">KOPTU. AHMAD BUHORI</div>
                    <div class="signature-nrp">NRP. 31071518250886</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
