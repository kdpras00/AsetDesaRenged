@extends('layouts.app')

@section('title', 'Dashboard Kepala Desa - Desa Renged')

@section('sidebar')
<ul class="space-y-2 font-medium">
    <li>
        <a href="{{ route('kepala-desa.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group bg-gray-100 dark:bg-gray-700">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
            </svg>
            <span class="ms-3">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Verifikasi Surat</span>
            @if($stats['pending_verification'] > 0)
                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">{{ $stats['pending_verification'] }}</span>
            @endif
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Kepala Desa</h1>
    <p class="text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-blue-600">
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Aset</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_assets'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-green-600">
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Nilai Aset</h3>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Rp {{ number_format($stats['total_asset_value'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-yellow-600">
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Verifikasi</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['pending_verification'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-purple-600">
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat Terverifikasi</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['verified_letters'] }}</p>
    </div>
</div>

<!-- Pending Verification -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Surat Menunggu Verifikasi</h2>
    </div>
    <div class="p-6">
        @forelse($recent_letters as $letter)
            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $letter->letterType->name }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">No. Surat: {{ $letter->letter_number }}</p>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Diproses</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-400 mt-3">
                    <p><span class="font-medium">Pemohon:</span> {{ $letter->user->name }}</p>
                    <p><span class="font-medium">Operator:</span> {{ $letter->operator->name ?? '-' }}</p>
                    <p><span class="font-medium">Tanggal Ajuan:</span> {{ $letter->request_date->format('d M Y') }}</p>
                    <p><span class="font-medium">Tanggal Proses:</span> {{ $letter->process_date?->format('d M Y') ?? '-' }}</p>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Verifikasi Sekarang →
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada surat yang perlu diverifikasi</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Semua surat sudah terverifikasi</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
