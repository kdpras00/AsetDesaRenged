@extends('layouts.public')

@section('title', 'Verifikasi Surat - Website Resmi Desa Renged')

@section('content')
<div class="relative min-h-[600px] flex items-center justify-center py-20 bg-gray-100">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/images/background-renged4.jpeg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
    </div>

    <div class="relative z-10 w-full max-w-lg px-4">
        <div class="bg-white rounded-lg shadow-xl border-t-4 border-blue-600 overflow-hidden">
            <div class="bg-blue-50 p-6 text-center border-b border-blue-100">
                <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-16 w-auto mx-auto mb-4" alt="Logo">
                <h2 class="text-2xl font-bold text-blue-900">Verifikasi Surat</h2>
                <p class="text-blue-600 text-sm">Validasi Dokumen Resmi Pemerintah Desa Renged</p>
            </div>
            
            <div class="p-8">
                 @if(session('error'))
                    <div class="mb-6 p-4 text-sm text-red-800 rounded border border-red-200 bg-red-50 text-center" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if(isset($letter))
                    <!-- Result Card -->
                     <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-700 mb-6">Dokumen Valid / Asli</h3>
                        
                        <div class="space-y-3 text-left bg-gray-50 p-6 rounded border border-gray-200 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nomor Surat</span>
                                <span class="font-bold text-gray-900">{{ $letter->letter_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Jenis Surat</span>
                                <span class="font-bold text-gray-900">{{ $letter->letterType->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pemohon</span>
                                <span class="font-bold text-gray-900">{{ $letter->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Terbit</span>
                                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-8">
                             <a href="{{ route('verification.index') }}" class="inline-block w-full py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition">Cek Dokumen Lain</a>
                        </div>
                     </div>
                @else
                    <form action="{{ route('verification.verify') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Verifikasi / Nomor Surat</label>
                            <input type="text" name="code" id="code" class="w-full px-4 py-3 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-center text-lg tracking-wider uppercase font-mono" placeholder="Masukkan Kode Disini" required>
                            <p class="text-xs text-gray-500 mt-2 text-center">Kode verifikasi tertera di bagian bawah surat (QR Code)</p>
                        </div>
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                            Cek Validitas
                        </button>
                    </form>
                @endif
            </div>
            
            <div class="bg-gray-50 p-4 text-center text-xs text-gray-500 border-t border-gray-200">
                &copy; Sistem Verifikasi Digital Desa Renged
            </div>
        </div>
    </div>
</div>
@endsection
