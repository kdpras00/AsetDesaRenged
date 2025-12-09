@extends('layouts.public')

@section('title', 'Akses Ditolak - Desa Renged')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16 px-4 bg-gray-50">
    <div class="text-center max-w-lg mx-auto">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 text-red-600">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h1 class="text-6xl font-extrabold text-red-900 mb-4 tracking-tight">403</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Akses Ditolak</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. 
            Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator desa.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                Kembali
            </a>
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
