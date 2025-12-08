@extends('layouts.app')

@section('title', 'Dashboard Warga - Desa Renged')

@section('sidebar')
<ul class="space-y-2 font-medium">
    <li>
        <a href="{{ route('warga.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group bg-gray-100 dark:bg-gray-700">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
            </svg>
            <span class="ms-3">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Pinjam Aset</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Ajukan Surat</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Saya</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Warga</h1>
    <p class="text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <h3 class="text-sm font-medium opacity-90">Peminjaman Aktif</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['active_loans'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
        <h3 class="text-sm font-medium opacity-90">Surat Pending</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['pending_letters'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <h3 class="text-sm font-medium opacity-90">Surat Terverifikasi</h3>
        <p class="text-3xl font-bold mt-2">{{ $stats['verified_letters'] }}</p>
    </div>
</div>

<!-- Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Peminjaman</h2>
        </div>
        <div class="p-6">
            @forelse($recent_loans as $loan)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $loan->asset->name }}</h4>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ $loan->loan_date->format('d M Y') }}</span>
                        @if($loan->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                        @elseif($loan->status == 'approved')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Disetujui</span>
                        @elseif($loan->status == 'rejected')
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                        @else
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Dikembalikan</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada riwayat peminjaman</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pengajuan Surat</h2>
        </div>
        <div class="p-6">
            @forelse($recent_letters as $letter)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $letter->letterType->name }}</h4>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ $letter->request_date->format('d M Y') }}</span>
                        @if($letter->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                        @elseif($letter->status == 'processed')
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Diproses</span>
                        @elseif($letter->status == 'verified')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Terverifikasi</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengajuan surat</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
