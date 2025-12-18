@extends('layouts.app')

@section('title', 'Verifikasi Surat - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Layanan Surat Desa</h1>
             <p class="text-gray-500 text-sm">Verifikasi administrasi pengajuan surat warga.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <a href="{{ route('operator.letters.index', ['status' => 'pending']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'pending' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Menunggu Verifikasi
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('operator.letters.index', ['status' => 'processed']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'processed' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Diproses (Menunggu Kades)
                </a>
            </li>
            <li class="mr-2">
                 <a href="{{ route('operator.letters.index', ['status' => 'history']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'history' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Riwayat
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">PEMOHON</th>
                        <th class="px-6 py-3">JENIS SURAT</th>
                        <th class="px-6 py-3">TANGGAL PENGAJUAN</th>
                        <th class="px-6 py-3">KEPERLUAN</th>
                        <th class="px-6 py-3 text-center">STATUS</th>
                        <th class="px-6 py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($letters as $letter)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $letter->user->name }}
                            <div class="text-xs text-gray-500">{{ $letter->user->nik }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $letter->letterType->name }}</span>
                            @if($letter->letter_number)
                                <div class="text-xs text-blue-600 font-mono">{{ $letter->letter_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($letter->request_date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate">
                            {{ $letter->purpose }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($letter->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            @elseif($letter->status == 'processed')
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">Paraf Operator</span>
                            @elseif($letter->status == 'verified')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($letter->status == 'pending')
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('operator.letters.show', $letter) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Lihat & Proses
                                    </a>
                                </div>
                            @elseif($letter->status == 'verified')
                                <a href="{{ route('operator.letters.download', $letter) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Unduh</a>
                            @else
                                <a href="{{ route('operator.letters.show', $letter) }}" class="text-gray-500 hover:text-gray-700 text-xs">Detail</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data surat di kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $letters->appends(['status' => $status])->links() }}
        </div>
    </div>
</div>
@endsection
