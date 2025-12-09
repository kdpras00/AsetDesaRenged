<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letter->letterType->name }} - {{ $letter->user->name }}</title>
    <style>
        @page {
            margin: 0.5cm 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .header {
            text-align: center;
            font-weight: bold;
            border: 2px solid #000;
            padding: 5px;
            margin-bottom: 5px;
            position: relative;
        }
        .form-code {
            position: absolute;
            top: -15px;
            right: 0;
            background: white;
            padding: 0 5px;
            font-weight: bold;
            font-size: 10pt;
            border: 1px solid #000;
        }
        .instructions {
            font-size: 8pt;
            margin-bottom: 5px;
            border: 1px solid #000;
            padding: 5px;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 5px;
        }
        .grid-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }
        .no-border {
            border: none !important;
        }
        .label-cell {
            width: 250px;
            font-weight: bold;
        }
        .code-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            text-align: center;
            line-height: 15px;
            margin-right: 1px;
            font-family: monospace;
            font-size: 9pt;
        }
        .char-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            text-align: center;
            line-height: 15px;
            margin-right: 1px;
            font-size: 9pt;
            vertical-align: middle;
            text-transform: uppercase;
        }
        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            text-align: center;
            line-height: 14px;
            margin-right: 5px;
            font-weight: bold;
        }
        .section-header {
            font-style: italic;
            text-decoration: underline;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .signature-section {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .signature-section td {
            vertical-align: top;
            text-align: center;
            padding: 10px;
        }
        .photo-box {
            width: 2.5cm;
            height: 3.5cm;
            border: 1px dashed #000;
            text-align: center;
            line-height: 3.5cm;
            margin: 0 auto;
            border-radius: 50%; /* Oval */
        }
        .thumb-box {
             width: 3cm;
            height: 3cm;
            border: 1px solid #000;
             margin: 0 auto;
        }
    </style>
</head>
<body>
    <div style="position: relative;">
        <div class="form-code">F-1.21</div>
        <div class="header">
            FORMULIR PERMOHONAN KARTU TANDA PENDUDUK (KTP) WARGA NEGARA INDONESIA
        </div>
    </div>

    <div class="instructions">
        <strong>Perhatian :</strong><br>
        1. Harap di isi dengan huruf cetak dan menggunakan tinta hitam<br>
        2. Untuk kolom pilihan, harap memberi tanda silang (X) pada kotak pilihan.<br>
        3. Setelah formulir ini diisi dan ditandatangani, harap diserahkan kembalike kantor Desa/Kelurahan
    </div>

    <table class="grid-table">
        <tr>
            <td class="label-cell">PEMERINTAH PROVINSI</td>
            <td style="width: 30px; text-align: center;">:</td>
            <td>
                <span class="code-box">3</span><span class="code-box">6</span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <strong>BANTEN</strong>
            </td>
        </tr>
         <tr>
            <td class="label-cell">PEMERINTAH KABUPATEN/KOTA</td>
            <td style="width: 30px; text-align: center;">:</td>
            <td>
                <span class="code-box">0</span><span class="code-box">3</span>
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <strong>TANGERANG</strong>
            </td>
        </tr>
         <tr>
            <td class="label-cell">KECAMATAN</td>
            <td style="width: 30px; text-align: center;">:</td>
             <td>
                <span class="code-box">0</span><span class="code-box">6</span>
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <strong>KRESEK</strong>
            </td>
        </tr>
         <tr>
            <td class="label-cell">KELURAHAN/DESA</td>
            <td style="width: 30px; text-align: center;">:</td>
             <td>
                <span class="code-box">2</span><span class="code-box">0</span><span class="code-box">0</span><span class="code-box">9</span>
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <strong>RENGED</strong>
            </td>
        </tr>
    </table>

    <div style="margin: 10px 0;">
        <span class="section-header">PERMOHONAN KTP</span>
        
        @php
            $ktpType = $letter->data['ktp_type'] ?? '';
        @endphp

        <span style="margin-left: 20px;">
            <span class="checkbox">{{ $ktpType == 'Baru' ? 'X' : '' }}</span> A. Baru
        </span>
        <span style="margin-left: 20px;">
            <span class="checkbox">{{ $ktpType == 'Perpanjangan' ? 'X' : '' }}</span> B. Perpanjangan
        </span>
         <span style="margin-left: 20px;">
            <span class="checkbox">{{ $ktpType == 'Penggantian' ? 'X' : '' }}</span> C. Penggantian
        </span>
    </div>

    @php
        function renderCharBoxes($text, $length = 32) {
            $html = '';
            for ($i = 0; $i < $length; $i++) {
                $char = isset($text[$i]) ? $text[$i] : '';
                 $html .= '<span class="char-box">' . $char . '</span>';
            }
            return $html;
        }
    @endphp

    <table class="grid-table" style="border: none;">
        <tr>
            <td class="no-border" style="width: 150px;">1. Nama Lengkap</td>
            <td class="no-border">
                {!! renderCharBoxes(strtoupper($letter->user->name)) !!}
            </td>
        </tr>
         <tr>
            <td class="no-border">2. No. KK</td>
            <td class="no-border">
                {!! renderCharBoxes($letter->user->kk ?? '') !!}
            </td>
        </tr>
         <tr>
            <td class="no-border">3. NIK</td>
            <td class="no-border">
                {!! renderCharBoxes($letter->user->nik ?? '') !!}
            </td>
        </tr>
         <tr>
            <td class="no-border">4. Alamat</td>
            <td class="no-border">
                 KP. {!! renderCharBoxes($letter->user->address ?? '', 28) !!}
            </td>
        </tr>
    </table>

    <table class="grid-table" style="border: none; margin-top: 5px;">
        <tr>
            <td class="no-border" style="width: 150px;"></td>
            <td class="no-border" style="width: 400px;">
                <div style="display: flex; align-items: center;">
                    <div style="border: 1px solid #000; padding: 2px 10px; margin-right: 10px;">RT</div>
                    <span class="code-box">{{ substr($letter->user->rt ?? '00', 0, 1) }}</span>
                    <span class="code-box">{{ substr($letter->user->rt ?? '00', 1, 1) }}</span>
                    <span class="code-box"></span>
                    
                    <div style="border: 1px solid #000; padding: 2px 10px; margin-right: 10px; margin-left: 20px;">RW</div>
                    <span class="code-box">{{ substr($letter->user->rw ?? '00', 0, 1) }}</span>
                    <span class="code-box">{{ substr($letter->user->rw ?? '00', 1, 1) }}</span>
                    
                     <div style="border: 1px solid #000; padding: 2px 10px; margin-right: 10px; margin-left: 50px;">Kode Pos :</div>
                    <span class="code-box">1</span><span class="code-box">5</span><span class="code-box">6</span><span class="code-box">2</span><span class="code-box">0</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="signature-section" border="1" style="border: 1px solid #000;">
        <tr>
            <td style="width: 20%;">Pas Photo (2x3)</td>
            <td style="width: 20%;">Cap Jempol</td>
            <td style="width: 60%;" colspan="2">Specimen Tanda Tangan</td>
        </tr>
        <tr>
            <td style="height: 100px; vertical-align: middle;">
                 <div class="photo-box">Oval</div>
            </td>
            <td style="vertical-align: middle;">
                 <div class="thumb-box"></div>
            </td>
            <td colspan="2" style="position: relative;">
                <div style="position: absolute; top: 10px; left: 10px;">Atau--></div>
                 <div style="width: 100%; height: 80px; border-bottom: 1px dashed #ccc;"></div>
                 <div style="text-align: center; margin-top: 5px; font-size: 8pt;">Ket: Cap Jempol/Tanda Tangan</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="no-border" style="text-align: right; padding-right: 50px; padding-top: 20px;">
                ...........................,.........................................
            </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border" style="text-align: left; padding-left: 20px;">
                Camat ..............................................................
            </td>
            <td class="no-border" style="padding-top: 0;">
                Mengetahui,
            </td>
            <td class="no-border" style="text-align: center;">
                Pemohon,
            </td>
        </tr>
        <tr>
             <td colspan="2" class="no-border"></td>
             <td class="no-border" style="text-align: center;">
                 a.n. Kepala Desa Renged<br>
                 Sekretaris Desa
             </td>
              <td class="no-border"></td>
        </tr>
         <tr>
             <td colspan="2" class="no-border" style="height: 60px;"></td>
             <td class="no-border" style="vertical-align: middle;">
                  <div style="margin: 0 auto; width: 90px;">
                    @if($letter->status == 'verified' && $letter->sha256_hash)
                         <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(80)->generate(route('verification.verify.hash', $letter->sha256_hash))) }}" alt="QR Code">
                    @endif
                </div>
             </td>
             <td class="no-border" style="vertical-align: bottom;">
                 ( ..............................................................)
             </td>
        </tr>
        <tr>
            <td colspan="2" class="no-border" style="text-align: left; padding-left: 20px;">
               ( .............................................................)<br>
               NIP.
            </td>
             <td class="no-border" style="text-align: center; font-weight: bold;">
                 ( DEVI FITRIA )
             </td>
              <td class="no-border"></td>
        </tr>
    </table>

</body>
</html>
