<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan - {{ $letter->letter_number }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 1.5cm 2cm;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            width: 65px;
            height: auto;
            position: absolute;
            left: 10px;
            top: 5px;
        }
        .header h2, .header h3, .header p {
            margin: 0;
        }
        .header h2 { font-size: 16pt; font-weight: bold; }
        .header h3 { font-size: 14pt; font-weight: bold; }
        .header p { font-size: 11pt; }
        
        .title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
            margin-top: 20px;
            margin-bottom: 0px;
            text-transform: uppercase;
        }
        .nomor {
            text-align: center;
            font-size: 12pt;
            margin-top: 0px;
            margin-bottom: 30px;
        }
        
        .content { margin-bottom: 30px; text-align: justify; }
        .data-table {
            width: 100%;
            margin-left: 30px;
            margin-bottom: 20px;
        }
        .data-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .label { width: 140px; }
        .sep { width: 10px; }
        
        .footer {
            width: 100%;
            margin-top: 30px;
        }
        .signature {
            float: right;
            width: 200px;
            text-align: left;
        }
        .qr-code {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .qr-code img {
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ storage_path('app/public/images/logo-renged.png') }}" alt="Logo Desa">
        <h2>PEMERINTAH KABUPATEN TANGERANG</h2>
        <h3>KECAMATAN KRESEK</h3>
        <h2>DESA RENGED</h2>
        <p>Alamat: Jl. Raya Kresek Km. 3, Desa Renged, Kec. Kresek, Kab. Tangerang</p>
    </div>

    <div class="title">{{ strtoupper($letter->letterType->name) }}</div>
    <div class="nomor">Nomor: {{ $letter->letter_number }}</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Renged, Kecamatan Kresek, Kabupaten Tangerang, menerangkan bahwa:</p>
        
        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="sep">:</td>
                <td><b>{{ strtoupper($letter->user->name) }}</b></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="sep">:</td>
                <td>{{ $letter->user->nik }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="sep">:</td>
                <td>{{ $letter->user->address }}, RT/RW {{ $letter->user->rt_rw }}</td>
            </tr>
            <tr>
                <td class="label">Keperluan</td>
                <td class="sep">:</td>
                <td>{{ $letter->purpose }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga Desa Renged, Kecamatan Kresek, Kabupaten Tangerang. Surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        
        <p>Demikian surat keterangan ini kami buat dengan sebenarnya.</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Renged, {{ $letter->approved_date ? \Carbon\Carbon::parse($letter->approved_date)->translatedFormat('d F Y') : ($letter->process_date ? \Carbon\Carbon::parse($letter->process_date)->translatedFormat('d F Y') : now()->translatedFormat('d F Y')) }}</p>
            <p>Kepala Desa Renged</p>
            
            <div class="qr-code">
                 <!-- QR Code Image -->
                 @if($letter->qr_code && file_exists(storage_path('app/public/' . $letter->qr_code)))
                    <img src="{{ storage_path('app/public/' . $letter->qr_code) }}" alt="QR Code">
                 @else
                    <br><br><br>
                 @endif
            </div>

            <p><b>{{ $letter->kepalaDesa->name ?? '(Nama Kepala Desa)' }}</b></p>
        </div>
        <div style="clear: both;"></div>
        <div style="margin-top: 20px; font-size: 10pt; font-style: italic;">
            Catatan: Surat ini diterbitkan secara elektronik dan ditandatangani menggunakan Barcode/QR Code, sehingga tidak memerlukan tanda tangan dan stempel basah.
        </div>
    </div>

</body>
</html>
