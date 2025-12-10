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
            font-weight: bold;
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
        .left-signature {
            display: inline-block;
            width: 220px;
            text-align: left;
            float: left;
            margin-top: 15px;
        }
        .empty-space {
            height: 5px;
        }
        .footer-note {
            font-size: 8pt;
            margin-top: 20px;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('storage/images/logo-renged.png') }}" alt="Logo">
        <h2>PEMERINTAH KABUPATEN TANGERANG</h2>
        <h3>KECAMATAN KRESEK</h3>
        <h1>DESA RENGED</h1>
        <p>Jl. Kp. Solokan Rt.12/04 Desa Renged Kecamatan Kresek - Tangerang Kode Pos 15620</p>
        <p>Email:<a href="mailto:Desarenged9@gmail.com">Desarenged9@gmail.com</a> Blog:<a href="https://Infodesarenged.blogspot.com">https://Infodesarenged.blogspot.com</a></p>
    </div>

        @php
            $date = $letter->approved_date ?? $letter->process_date ?? $letter->request_date ?? now();
        @endphp

    <div class="title">
        <h4>SURAT KETERANGAN USAHA</h4>
        <p>Nomor : 511.3 / {{ $letter->letter_number ?? '.......' }} - Ds.Rgd / {{ \App\Helpers\Romawi::get($date->format('n')) }} / {{ $date->format('Y') }}</p>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan dibawah ini Kepala Desa Renged Kecamatan Kresek Kabupaten Tangerang, menerangkan dengan sesungguhnya bahwa :
        </p>

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
                <td>{{ $letter->user->birth_place }}, {{ \Carbon\Carbon::parse($letter->user->birth_date)->translatedFormat('d-m-Y') }}</td>
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
                <td class="label-col">Pekerjaan</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->job ?? 'Wiraswasta' }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat</td>
                <td class="separator-col">:</td>
                <td>{{ $letter->user->address }}</td>
            </tr>
        </table>
        
        @php
            $data = $letter->data ?? [];
        @endphp

        <p>Dengan ini menerangkan bahwa benar yang bersangkutan pada saat ini memiliki / membuka usaha di wilayah administrasi Kami sebagai berikut:</p>
        
        <table class="table-data">
            <tr>
                <td class="label-col">Nama Usaha</td>
                <td class="separator-col">:</td>
                <td><strong>" {{ strtoupper($data['business_name'] ?? '-') }} "</strong></td>
            </tr>
            <tr>
                <td class="label-col">Jenis Usaha</td>
                <td class="separator-col">:</td>
                <td>{{ $data['business_type'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat Usaha</td>
                <td class="separator-col">:</td>
                <td>{{ $data['business_address'] ?? '-' }}</td>
            </tr>
        </table>

        <!-- Start Date: Approved Date. End Date: +1 Year -->
        @php
            $startDate = $date;
            $endDate = (clone $date)->addYear();
        @endphp

        <p style="text-align: justify; font-weight: bold;">
            Surat Keterangan Usaha ini berlaku selama (1 tahun ) sejak di keluarkannya surat ini Tanggal {{ $startDate->translatedFormat('d F Y') }} s/d {{ $endDate->translatedFormat('d F Y') }}.
        </p>

        <p style="margin-top: 15px;">
            Demikian surat Keterangan Usaha ini kami buat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        <div class="signature">
             <div class="signature-box">
                <p>Renged, {{ $date->translatedFormat('d F Y') }}<br>
                A.n Kepala Desa Renged<br>
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

            <!-- Optional: Left signature if needed (RT/RW), but image doesn't show clearly. 
                 The image shows "Mengetahui RT 06/05", assuming static or from user address? 
                 I'll add a static placeholders or logic.
                 The image shows "Mengetahui RT 06/05" on the left.
            -->
            <div class="left-signature">
                <p>{{ date('Y') }}<br>
                Mengetahui<br>
                RT {{ $letter->user->rt ?? '...' }}/{{ $letter->user->rw ?? '...' }}</p>
                <br><br><br>
                <p>.......................................</p>
            </div>
        </div>

        <div class="footer-note">
            <p>Catatan :<br>
            *Dilarang menjual obat-obatan terlarang / tidak ada ijin dari BPOM*<br>
            Jika diketahui dikemudian hari menjual dan mengedarkan barang tersebut, kami akan mencabut ijin usaha anda dan akan diproses sesuai undang-undang yang berlaku.</p>
        </div>
    </div>
</body>
</html>
