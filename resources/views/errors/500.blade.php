@extends('layouts.public')

@section('title', 'Kesalahan Server - Desa Renged')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16 px-4 bg-gray-50">
    <div class="text-center max-w-lg mx-auto">
        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 text-yellow-600">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <h1 class="text-6xl font-extrabold text-yellow-900 mb-4 tracking-tight">500</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Terjadi Kesalahan Server</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Maaf, terjadi kesalahan internal pada server kami. 
            Tim teknis kami telah diberitahu dan sedang bekerja untuk memperbaikinya.
            Silakan coba lagi beberapa saat lagi.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
