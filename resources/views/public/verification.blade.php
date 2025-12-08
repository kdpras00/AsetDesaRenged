@extends('layouts.public')

@section('title', 'Verifikasi Surat - Sistem Manajemen Aset Desa Renged')

@section('content')
<div class="relative min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged4.jpeg') }}" alt="Security Background" class="h-full w-full object-cover object-center opacity-5">
    </div>
    
    <div class="relative w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 mb-6">
                <svg class="h-10 w-10 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Verifikasi Surat</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Pastikan keaslian dokumen resmi Desa Renged dengan memasukkan kode verifikasi atau memindai QR Code.
            </p>
        </div>

        @if(session('error'))
            <div class="p-4 rounded-md bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm font-medium text-center">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($letter))
            <!-- Result Card -->
             <div class="p-6 bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-center mb-4 text-green-600 dark:text-green-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-center text-green-800 dark:text-green-300 mb-2">Dokumen Valid</h3>
                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <p><strong>Nomor Surat:</strong> {{ $letter->letter_number }}</p>
                    <p><strong>Jenis:</strong> {{ $letter->letterType->name }}</p>
                    <p><strong>Pemohon:</strong> {{ $letter->user->name }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d F Y') }}</p>
                </div>
             </div>
        @else
            <!-- Form -->
            <form class="mt-8 space-y-6" action="{{ route('verification.verify') }}" method="POST">
                @csrf
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="code" class="sr-only">Kode Verifikasi</label>
                        <input id="code" name="code" type="text" required class="relative block w-full rounded-md border-0 py-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-blue-600 text-center text-xl tracking-widest sm:text-lg sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 uppercase" placeholder="Masukkan 12 Digit Kode">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative flex w-full justify-center rounded-md bg-blue-600 px-3 py-3 text-sm font-semibold text-white hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-colors">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                          <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                          </svg>
                        </span>
                        Verifikasi Sekarang
                    </button>
                    <div class="text-center mt-4">
                        <button type="button" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex items-center justify-center w-full gap-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                             Scan QR Code (Coming Soon)
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
