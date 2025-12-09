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
            padding-bottom: 5px;
            margin-bottom: 15px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 0;
            width: 65px;
            height: auto;
        }
        .header h2 {
            font-size: 14pt;
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
        .header p {
            font-size: 10pt;
            margin: 0;
        }
        .title {
            text-align: center;
            margin-bottom: 15px;
        }
        .title h4 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
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
            margin: 10px 0 10px 15px;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 2px 0;
            font-size: 11pt;
        }
        .points {
            margin-left: 20px;
            margin-top: 5px;
            font-style: italic;
            font-weight: bold;
        }
        .signature {
            margin-top: 20px;
            width: 100%;
            text-align: right; 
        }
        .signature-box {
            display: inline-block;
            width: 220px;
            text-align: center;
            float: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('storage/images/logo-renged.png') }}" alt="Logo">
        <h2>PEMERINTAH KABUPATEN TANGERANG</h2>
        <h3>KECAMATAN KRESEK</h3>
        <h2>DESA RENGED</h2>
        <p>Jl. Raya Kresek Km. 03 Kp. Renged RT. 003/001 Kode Pos 15620</p>
        <p>Email: pemdesrenged@gmail.com</p>
    </div>

    <div class="title">
        <h4>SURAT PENGANTAR KETERANGAN CATATAN KEPOLISIAN (SKCK)</h4>
        <p>Nomor : 470 / {{ $letter->letter_number ?? '.......' }} / Ds.Rgd / {{ date('Y') }}</p>
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
                <td>{{ $letter->user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Tempat/Tgl.Lahir</td>
                <td>:</td>
                <td>{{ $letter->user->birth_place }}, {{ \Carbon\Carbon::parse($letter->user->birth_date)->translatedFormat('d-m-Y') }}</td>
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
                <td>{{ $letter->user->religion ?? 'Islam' }}</td>
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

        <p style="margin-top: 15px;">
            Demikian keterangan ini dibuat dengan sesungguhnya untuk dapat diketahui semestinya dan kepada pihak terkait dimohon kelanjutannya agar yang bersangkutan dapat dibuatkan Surat Keterangan Catatan Kepolisian (SKCK) dengan maksud tujuan <strong>"{{ $letter->purpose }}"</strong>.
        </p>

        <div class="signature">
            <div class="signature-box">
                <p>Renged, {{ now()->translatedFormat('d F Y') }}<br>
                Kepala Desa Renged</p>
                
                <div style="margin: 10px auto;">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(90)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                        <br>
                        <span style="font-size: 8pt; color: #555;"><i>Ditandatangani Secara Elektronik</i></span>
                    @else
                        <br><br><br><br>
                    @endif
                </div>
                
                <p style="text-decoration: underline; font-weight: bold;">
                    {{ $letter->approvedBy ? $letter->approvedBy->name : 'APUD MAHFUD, S.Pd' }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
