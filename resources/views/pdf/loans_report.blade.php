<!DOCTYPE html>
<html>
<head>
    <title>Laporan Historis Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; }
        .status-pending { color: #d97706; }
        .status-approved { color: #2563eb; }
        .status-returned { color: #16a34a; }
        .status-rejected { color: #dc2626; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH KABUPATEN TANGERANG</h1>
        <h2>PEMERINTAH DESA RENGED</h2>
        <p>Alamat: Jl. Raya Kresek Km. 3, Desa Renged, Kec. Kresek, Kab. Tangerang</p>
        <hr>
        <h3>LAPORAN RIWAYAT PEMINJAMAN ASET</h3>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Aset</th>
                <th>Jml</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->asset->name }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td>{{ \Carbon\Carbon::parse($item->loan_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') }}</td>
                <td>{{ $item->purpose }}</td>
                <td>
                    @if($item->status == 'pending') <span class="status-pending">Menunggu</span>
                    @elseif($item->status == 'approved') <span class="status-approved">Dipinjam</span>
                    @elseif($item->status == 'returning') <span class="status-pending">Pengajuan Kembali</span>
                    @elseif($item->status == 'returned') <span class="status-returned">Selesai</span>
                    @else <span class="status-rejected">Ditolak</span> @endif
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
