@extends('layouts.app')

@section('title', 'Dashboard Operator - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Operator</h1>
    <p class="text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Assets -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Aset</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_assets'] }}</p>
            </div>
        </div>
    </div>

    <!-- Available Assets -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Aset Tersedia</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['available_assets'] }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Loans -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Peminjaman Pending</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_loans'] }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Letters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat Pending</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_letters'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pending Loans -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Peminjaman Menunggu Approval</h2>
        </div>
        <div class="p-6">
            @forelse($recent_loans as $loan)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $loan->asset->name }}</h4>
                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Peminjam: {{ $loan->user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Jumlah: {{ $loan->quantity }} unit</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ $loan->loan_date->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada peminjaman pending</p>
            @endforelse
        </div>
    </div>

    <!-- Pending Letters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pengajuan Surat Baru</h2>
        </div>
        <div class="p-6">
            @forelse($recent_letters as $letter)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $letter->letterType->name }}</h4>
                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pemohon: {{ $letter->user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Keperluan: {{ Str::limit($letter->purpose, 50) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ $letter->request_date->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada pengajuan surat baru</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
