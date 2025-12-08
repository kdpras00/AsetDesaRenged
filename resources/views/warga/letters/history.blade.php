@extends('layouts.app')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Clean Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Pengajuan Surat</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar semua permohonan surat keterangan Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-gray-100 rounded-lg px-4 py-2 text-center">
                <span class="block text-xl font-bold text-gray-900">{{ $letters->total() }}</span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Total</span>
            </div>
            <a href="{{ route('warga.letters.index', ['view' => 'catalog']) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Surat Baru
            </a>
        </div>
    </div>

    <!-- Letters List -->
    <div class="space-y-4">
        @forelse($letters as $letter)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Letter Info -->
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $letter->letterType->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $letter->purpose }}</p>
                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($letter->request_date)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex-shrink-0">
                        @if($letter->status == 'pending')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu
                            </span>
                        @elseif($letter->status == 'processed')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Diproses
                            </span>
                        @elseif($letter->status == 'verified')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Rejection Reason -->
                @if($letter->status == 'rejected' && $letter->rejection_reason)
                    <div class="mt-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-100">
                        <strong>Alasan Penolakan:</strong> {{ $letter->rejection_reason }}
                    </div>
                @endif

                <!-- Download Button for Verified Letters -->
                @if($letter->status == 'verified')
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('warga.letters.download', $letter) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Surat (PDF)
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Belum Ada Pengajuan Surat</h3>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto p-2">Mulai ajukan surat keterangan yang Anda butuhkan.</p>
            <a href="{{ route('warga.letters.index', ['view' => 'catalog']) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                Lihat Jenis Surat
            </a>
        </div>
        @endforelse
    </div>

    @if($letters->hasPages())
    <div class="mt-8">
        {{ $letters->appends(['view' => 'history'])->links() }}
    </div>
    @endif
</div>
@endsection
