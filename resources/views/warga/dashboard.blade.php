@extends('layouts.app')

@section('title', 'Dashboard Warga - Desa Renged')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8 relative rounded-xl overflow-hidden bg-green-600">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-20" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900 via-green-800 to-transparent"></div>
    </div>
    <div class="relative p-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-green-100">Akses layanan publik desa dengan mudah dan cepat.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Peminjaman Aktif</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['active_loans'] }}</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
             <div class="w-14 h-14 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Surat Pending</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['pending_letters'] }}</div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="flex-shrink-0 mr-4">
            <div class="w-14 h-14 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium text-gray-500">Surat Terverifikasi</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['verified_letters'] }}</div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Loan History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-900 text-lg">Riwayat Peminjaman</h2>
            <a href="{{ route('warga.loans.index') }}" class="text-sm text-green-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent_loans as $loan)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $loan->asset->name }}</h4>
                        @if($loan->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-0.5 rounded">Pending</span>
                        @elseif($loan->status == 'approved')
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-0.5 rounded">Dipinjam</span>
                        @elseif($loan->status == 'rejected')
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-0.5 rounded">Ditolak</span>
                        @else
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-0.5 rounded">Selesai</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>{{ $loan->loan_date->format('d M Y') }}</span>
                         <span>{{ $loan->quantity }} Unit</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">Belum ada riwayat peminjaman.</div>
            @endforelse
        </div>
    </div>

    <!-- Letter History -->
     <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-900 text-lg">Pengajuan Surat</h2>
            <a href="{{ route('warga.letters.index') }}" class="text-sm text-green-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent_letters as $letter)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $letter->letterType->name }}</h4>
                        @if($letter->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-0.5 rounded">Pending</span>
                        @elseif($letter->status == 'processed')
                             <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-0.5 rounded">Diproses</span>
                        @elseif($letter->status == 'verified')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-0.5 rounded">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-0.5 rounded">Ditolak</span>
                        @endif
                    </div>
                     <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>{{ $letter->request_date->format('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">Belum ada pengajuan surat.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
