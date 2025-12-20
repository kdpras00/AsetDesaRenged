<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arsip Surat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH KABUPATEN TANGERANG</h1>
        <h2>PEMERINTAH DESA RENGED</h2>
        <p>Alamat: Jl. Raya Kresek Km. 3, Desa Renged, Kec. Kresek, Kab. Tangerang</p>
        <hr>
        <h3>LAPORAN ARSIP LAYANAN SURAT</h3>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Pemohon</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($letters as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->letter_number ?? '(Belum Terbit)' }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->letterType->name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->request_date)->format('d F Y') }}</td>
                <td>
                    @if($item->status == 'verified') Terverifikasi
                    @elseif($item->status == 'rejected') Ditolak
                    @else Dalam Proses @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Renged, {{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p><strong>Kepala Desa Renged</strong></p>
        <br><br><br>
        <p>_______________________</p>
    </div>
</body>
</html>
