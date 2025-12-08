@extends('layouts.app')

@section('title', 'Dashboard Operator - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8 relative rounded-xl overflow-hidden bg-blue-600">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-20" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-800 to-transparent"></div>
    </div>
    <div class="relative p-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-blue-100">Selamat bekerja! Pantau terus aktivitas layanan desa hari ini.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Assets -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Total Aset</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_assets'] }}</div>
        </div>
    </div>

    <!-- Available Assets -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Aset Tersedia</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['available_assets'] }}</div>
        </div>
    </div>

    <!-- Pending Loans -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Peminjaman Pending</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['pending_loans'] }}</div>
        </div>
    </div>

    <!-- Pending Letters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Surat Pending</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['pending_letters'] }}</div>
        </div>
    </div>
</div>

<!-- Recent Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pending Loans -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-900 text-lg">Permintaan Peminjaman</h2>
            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent_loans as $loan)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center">
                            <div class="bg-blue-100 text-blue-700 font-bold px-2 py-1 rounded text-xs mr-3">LOAN</div>
                            <h4 class="font-bold text-gray-900">{{ $loan->asset->name }}</h4>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full border border-yellow-200">
                            Menunggu Persetujuan
                        </span>
                    </div>
                    <div class="pl-12 text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium text-gray-800">{{ $loan->user->name }}</span> mengajukan peminjaman</p>
                        <p class="text-gray-500">Jumlah: {{ $loan->quantity }} Unit &bull; {{ $loan->loan_date->format('d M Y') }}</p>
                    </div>
                    <div class="mt-4 pl-12 flex space-x-2">
                        <button class="px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded hover:bg-green-700 transition">Setujui</button>
                        <button class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition">Tolak</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-500">Tidak ada permintaan peminjaman baru.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pending Letters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-900 text-lg">Permintaan Surat</h2>
            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent_letters as $letter)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-2">
                         <div class="flex items-center">
                            <div class="bg-purple-100 text-purple-700 font-bold px-2 py-1 rounded text-xs mr-3">SURAT</div>
                             <h4 class="font-bold text-gray-900">{{ $letter->letterType->name }}</h4>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full border border-yellow-200">
                            Menunggu Verifikasi
                        </span>
                    </div>
                    <div class="pl-12 text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium text-gray-800">{{ $letter->user->name }}</span> mengajukan surat</p>
                        <p class="text-gray-500">Keperluan: {{ Str::limit($letter->purpose, 40) }}</p>
                    </div>
                    <div class="mt-4 pl-12 flex space-x-2">
                        <button class="px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded hover:bg-blue-700 transition">Proses Surat</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-gray-500">Tidak ada permintaan surat baru.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
