@extends('layouts.public')

@section('title', 'Hasil Verifikasi Surat - Website Resmi Desa Renged')

@section('content')
<div class="relative min-h-[600px] flex items-center justify-center py-20 bg-gray-100">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/images/background-renged4.jpeg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
    </div>

    <div class="relative z-10 w-full max-w-2xl px-4">
        <div class="bg-white rounded-lg shadow-xl border-t-4 {{ isset($error) ? 'border-red-600' : 'border-green-600' }} overflow-hidden">
            <div class="{{ isset($error) ? 'bg-red-50' : 'bg-green-50' }} p-6 text-center border-b {{ isset($error) ? 'border-red-100' : 'border-green-100' }}">
                <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-16 w-auto mx-auto mb-4" alt="Logo">
                <h2 class="text-2xl font-bold {{ isset($error) ? 'text-red-900' : 'text-green-900' }}">Hasil Verifikasi Dokumen</h2>
                <p class="{{ isset($error) ? 'text-red-600' : 'text-green-600' }} text-sm">Sistem Verifikasi Digital Desa Renged</p>
            </div>
            
            <div class="p-8">
                @if(isset($error))
                    <!-- Error State -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 text-red-600 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-red-700 mb-3">❌ Dokumen Tidak Valid</h3>
                        <p class="text-red-600 mb-6">{{ $error }}</p>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-red-800">
                                <strong>Peringatan:</strong> Dokumen ini mungkin palsu atau tidak terdaftar dalam sistem kami. 
                                Silakan hubungi kantor desa untuk verifikasi lebih lanjut.
                            </p>
                        </div>
                        
                        <a href="{{ route('verification.index') }}" class="inline-block w-full py-3 bg-red-600 text-white font-bold rounded hover:bg-red-700 transition">
                            Cek Dokumen Lain
                        </a>
                    </div>
                @elseif(isset($letter))
                    <!-- Success State -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 text-green-600 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-700 mb-6">✅ Dokumen Valid & Asli</h3>
                        
                        <!-- Document Details -->
                        <div class="space-y-3 text-left bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Nomor Surat</span>
                                <span class="font-bold text-gray-900">{{ $letter->letter_number }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Jenis Surat</span>
                                <span class="font-bold text-gray-900">{{ $letter->letterType->name }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Pemohon</span>
                                <span class="font-bold text-gray-900">{{ $letter->user->name }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Tanggal Terbit</span>
                                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($letter->approved_date)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Ditandatangani Oleh</span>
                                <span class="font-bold text-gray-900">{{ $letter->kepalaDesa->name ?? 'N/A' }}</span>
                            </div>
                            
                            @if($letter->documentVerification)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Hash Verifikasi</span>
                                    <span class="font-mono text-xs text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                        {{ (new \App\Services\DocumentHashService())->getPartialHash($letter->sha256_hash) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('verification.index') }}" class="flex-1 py-3 bg-gray-600 text-white font-bold rounded hover:bg-gray-700 transition text-center">
                                Cek Dokumen Lain
                            </a>
                            <!-- Optional: Add download PDF button if PDF generation is implemented -->
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="bg-gray-50 p-4 text-center text-xs text-gray-500 border-t border-gray-200">
                &copy; {{ date('Y') }} Sistem Verifikasi Digital Desa Renged - Powered by SHA-256 Encryption
            </div>
        </div>
    </div>
</div>
@endsection
