@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan - Desa Renged')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16 px-4 bg-gray-50">
    <div class="text-center max-w-lg mx-auto">
        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 class="text-6xl font-extrabold text-blue-900 mb-4 tracking-tight">404</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Maaf, halaman yang Anda cari mungkin telah dihapus, dipindahkan, atau tidak tersedia saat ini.
            Silakan periksa kembali URL yang Anda masukkan.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
