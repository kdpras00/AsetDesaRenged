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
<!-- Recent Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pending Loans -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="font-bold text-gray-900 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Permintaan Peminjaman
            </h2>
            <a href="{{ route('operator.loans.index') }}" class="text-sm text-blue-600 font-medium hover:text-blue-700 hover:underline">Lihat Semua &rarr;</a>
        </div>
        <div class="divide-y divide-gray-100 flex-1">
            @forelse($recent_loans as $loan)
                <div class="group p-6 hover:bg-blue-50/30 transition-all duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col">
                            <h4 class="font-bold text-gray-900 text-base mb-1">{{ $loan->asset->name }}</h4>
                            <div class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block w-max">
                                {{ $loan->quantity }} Unit
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full border border-yellow-200 shadow-sm">
                            Menunggu Persetujuan
                        </span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                            {{ substr($loan->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $loan->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->loan_date->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('operator.loans.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center flex flex-col items-center justify-center h-64">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada permintaan</h3>
                    <p class="text-gray-500 mt-1">Belum ada peminjaman aset baru.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pending Letters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="font-bold text-gray-900 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Permintaan Surat
            </h2>
            <a href="{{ route('operator.letters.index') }}" class="text-sm text-blue-600 font-medium hover:text-blue-700 hover:underline">Lihat Semua &rarr;</a>
        </div>
        <div class="divide-y divide-gray-100 flex-1">
            @forelse($recent_letters as $letter)
                <div class="group p-6 hover:bg-purple-50/30 transition-all duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col">
                            <h4 class="font-bold text-gray-900 text-base mb-1">{{ $letter->letterType->name }}</h4>
                            <div class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block w-max">
                                {{ \Carbon\Carbon::parse($letter->created_at)->diffForHumans() }}
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full border border-yellow-200 shadow-sm">
                            Menunggu Verifikasi
                        </span>
                    </div>

                     <div class="flex items-center text-sm text-gray-600 mb-3">
                        <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs mr-3">
                            {{ substr($letter->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">{{ $letter->user->name }}</p>
                            <p class="text-xs text-gray-500 truncate max-w-[200px]" title="{{ $letter->purpose }}">Keperluan: {{ $letter->purpose }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('operator.letters.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                            Proses Surat
                        </a>
                    </div>
                </div>
            @empty
               <div class="p-12 text-center flex flex-col items-center justify-center h-64">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada surat</h3>
                    <p class="text-gray-500 mt-1">Belum ada pengajuan surat baru.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
