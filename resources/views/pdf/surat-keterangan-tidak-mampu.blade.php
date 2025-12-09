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
        <img src="{{ public_path('storage/images/logo-renged.png') }}" alt="Logo">
        <h2>PEMERINTAH KABUPATEN TANGERANG</h2>
        <h3>KECAMATAN KRESEK</h3>
        <h1>DESA RENGED</h1>
        <p>Jl.Kp.Solokan Rt.12/04 Kresek – Tangerang Kode Pos 15620</p>
        <p>Email:<a href="mailto:Desarenged9@gmail.com">Desarenged9@gmail.com</a> Blog:<a href="https://Infodesarenged.blogspot.com">https://Infodesarenged.blogspot.com</a></p>
    </div>

    <div class="title">
        <h4>SURAT KETERANGAN TIDAK MAMPU</h4>
        <p>Nomor : 401 / {{ $letter->letter_number ?? '044' }} / Ds.Rgd / {{ \App\Helpers\Romawi::get(date('n')) }} / {{ date('Y') }}</p>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan dibawah ini Kepala Desa Renged Kecamatan Kresek Kabupaten Tangerang, menerangkan dengan sesungguhnya bahwa :
        </p>

        @php
            $data = $letter->data ?? [];
        @endphp

        <table class="table-data">
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
                <td class="label-col">Jenis Kelamin</td>
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
                <td class="label-col">Pekerjaan</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->job ?? 'Pelajar/Mahasiswa' }}</td>
            </tr>
             <tr>
                <td class="label-col">Alamat</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->address }}</td>
            </tr>
        </table>
        
        <p>
            Nama tersebut adalah <strong><em>{{ $letter->user->gender == 'L' ? 'PUTRA' : 'PUTRI' }}</em></strong> dari Ayah & Ibu :
        </p>

        <!-- Father -->
        <table class="table-data">
            <tr>
                <td class="label-col">Nama</td>
                <td class="separator-col">:</td>
                <td><strong>{{ isset($data['father_name']) ? strtoupper($data['father_name']) : '-' }}</strong></td>
            </tr>
             <tr>
                <td class="label-col">NIK</td>
                <td class="separator-col">:</td>
                <td>{{ $data['father_nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Pekerjaan</td>
                <td class="separator-col">:</td>
                <td>{{ $data['father_job'] ?? '-' }}</td>
            </tr>
             <tr>
                <td class="label-col">Alamat</td>
                <td class="separator-col">:</td>
                <td>{{ $data['father_address'] ?? '-' }}</td>
            </tr>
        </table>

         <!-- Mother -->
        <table class="table-data">
            <tr>
                <td class="label-col">Nama</td>
                <td class="separator-col">:</td>
                <td><strong>{{ isset($data['mother_name']) ? strtoupper($data['mother_name']) : '-' }}</strong></td>
            </tr>
             <tr>
                <td class="label-col">NIK</td>
                <td class="separator-col">:</td>
                <td>{{ $data['mother_nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Pekerjaan</td>
                <td class="separator-col">:</td>
                <td>{{ $data['mother_job'] ?? '-' }}</td>
            </tr>
             <tr>
                <td class="label-col">Alamat</td>
                <td class="separator-col">:</td>
                <td>{{ $data['mother_address'] ?? '-' }}</td>
            </tr>
        </table>

        <p>
            Nama tersebut diatas adalah penduduk Desa Renged Kec.Kresek Kab.Tangerang, menurut keterangan dari Rt/Rw setempat dan pengakuan yang bersangkutan, hingga Surat Keterangan ini dibuat yang bersangkutan adalah <u><strong><em>Keluarga Tidak Mampu.</em></strong></u>
        </p>

        <p>
             Demikian keterangan ini dibuat dengan sesungguhnya untuk dapat diketahui dan dipergunakan semestinya.
        </p>

        <div class="signature">
             <div class="signature-box">
                <p>Renged, {{ now()->translatedFormat('d F Y') }}<br>
                An.Kepala Desa Renged<br>
                Sekretaris Desa</p>
                
                 <div style="margin: 10px auto;">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                         <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                        <br>
                    @else
                        <br><br><br><br>
                    @endif
                </div>

                <p style="text-decoration: underline; font-weight: bold;">
                    DEVI FITRIA, S.Pd
                </p>
            </div>
        </div>
    </div>
</body>
</html>
