@extends('layouts.app')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Clean Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Peminjaman</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar semua permohonan peminjaman aset Anda.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="bg-gray-100 rounded-lg px-4 py-2 text-center">
                <span class="block text-xl font-bold text-gray-900">{{ $loans->total() }}</span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Total</span>
            </div>
            <a href="{{ route('warga.loans.index', ['view' => 'catalog']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Pinjam Baru
            </a>
        </div>
    </div>

    <!-- Minimalist Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($loans as $loan)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden group">
            
            <!-- Card Header: Image & Status Overlay -->
            <div class="relative h-48 bg-gray-100">
                @if($loan->asset->image)
                    <img src="{{ Storage::url($loan->asset->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $loan->asset->name }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                
                <!-- Status Badge Overlay -->
                <div class="absolute top-4 right-4">
                    @if($loan->status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-400 text-yellow-900 shadow-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Menunggu
                        </span>
                    @elseif($loan->status == 'approved')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-600 text-white shadow-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Dipinjam
                        </span>
                    @elseif($loan->status == 'returned')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-500 text-white shadow-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-600 text-white shadow-sm">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-5 flex-1 flex flex-col">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1">{{ $loan->asset->name }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2" title="{{ $loan->purpose }}">
                        {{ $loan->purpose ?? 'Keperluan Pribadi' }}
                    </p>
                </div>

                <div class="mt-auto space-y-3">
                    <!-- Date Info -->
                    <div class="flex items-start text-sm text-gray-600 bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                        <svg class="w-4 h-4 mr-2.5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Pinjam: {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('d M Y') }}</div>
                            <div class="text-gray-500 text-xs mt-0.5">Kembali: {{ \Carbon\Carbon::parse($loan->return_date)->translatedFormat('d M Y') }}</div>
                        </div>
                    </div>

                    <!-- Quantity Info -->
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Jumlah:</span>
                        <span class="font-bold text-gray-900">{{ $loan->quantity }} Unit</span>
                    </div>

                     <!-- Rejection Reason -->
                     @if($loan->status == 'rejected' && $loan->rejection_reason)
                        <div class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100">
                            "{{ $loan->rejection_reason }}"
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Belum Ada Peminjaman</h3>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto p-2">Mulai ajukan peminjaman aset desa untuk mendukung kegiatan Anda.</p>
            <a href="{{ route('warga.loans.index', ['view' => 'catalog']) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                Lihat Katalog
            </a>
        </div>
        @endforelse
    </div>

    @if($loans->hasPages())
    <div class="mt-8">
        {{ $loans->appends(['view' => 'history'])->links() }}
    </div>
    @endif
</div>
@endsection
