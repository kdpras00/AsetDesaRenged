@extends('layouts.app')

@section('title', 'Laporan Desa - Desa Renged')

@section('sidebar')
    @include('kepala-desa.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Rekapitulasi Laporan</h1>
             <p class="text-gray-500 text-sm">Arsip laporan aset, peminjaman, dan layanan surat desa.</p>
        </div>
        @if($type == 'assets')
            <a href="{{ route('kepala-desa.reports.print-assets') }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition shadow-sm">
                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                 Download PDF Aset
            </a>
        @elseif($type == 'loans')
            <a href="{{ route('kepala-desa.reports.print-loans') }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition shadow-sm">
                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                 Download PDF Peminjaman
            </a>
        @elseif($type == 'letters')
            <a href="{{ route('kepala-desa.reports.print-letters') }}" target="_blank" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition shadow-sm">
                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                 Download PDF Surat
            </a>
        @endif
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <a href="{{ route('kepala-desa.reports.index', ['type' => 'assets']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $type == 'assets' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Inventaris Aset
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('kepala-desa.reports.index', ['type' => 'loans']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $type == 'loans' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Riwayat Peminjaman
                </a>
            </li>
            <li class="mr-2">
                 <a href="{{ route('kepala-desa.reports.index', ['type' => 'letters']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $type == 'letters' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Arsip Surat
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="overflow-x-auto">
            @if($type == 'assets')
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Nama Aset</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Kondisi</th>
                            <th class="px-6 py-3">Lokasi</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }} <br> <span class="text-xs text-gray-500 font-mono">{{ $item->code }}</span></td>
                            <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ ucfirst($item->condition) }}</td>
                            <td class="px-6 py-4">{{ $item->location ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                            <td class="px-6 py-4">{{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif($type == 'loans')
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Peminjam</th>
                            <th class="px-6 py-3">Aset</th>
                            <th class="px-6 py-3">Tanggal Pinjam</th>
                            <th class="px-6 py-3">Tanggal Kembali</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">{{ $item->asset->name }} ({{ $item->quantity }})</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->return_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($item->status == 'pending') <span class="text-yellow-600 font-bold">Pending</span>
                                @elseif($item->status == 'approved') <span class="text-blue-600 font-bold">Aktif</span>
                                @elseif($item->status == 'returned') <span class="text-green-600 font-bold">Selesai</span>
                                @else <span class="text-red-600 font-bold">Ditolak</span> @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif($type == 'letters')
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">No. Surat</th>
                            <th class="px-6 py-3">Pemohon</th>
                            <th class="px-6 py-3">Jenis Surat</th>
                            <th class="px-6 py-3">Tanggal Ajuan</th>
                            <th class="px-6 py-3">Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-900">{{ $item->letter_number ?? '(Pending)' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">{{ $item->letterType->name }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->request_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4">
                                 @if($item->status == 'verified') <span class="text-green-600 font-bold">Terverifikasi</span>
                                 @elseif($item->status == 'rejected') <span class="text-red-600 font-bold">Ditolak</span>
                                 @else <span class="text-gray-500">Proses</span> @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
