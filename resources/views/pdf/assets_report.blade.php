<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Aset</title>
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
        <h3>LAPORAN INVENTARIS ASET DESA</h3>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Aset</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ ucfirst($item->condition) }}</td>
                <td>{{ $item->location ?? '-' }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
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
