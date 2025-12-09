@extends('layouts.public')

@section('title', 'Struktur Organisasi - Website Resmi Desa Renged')

@section('content')
<!-- Page Header -->
<div class="relative bg-gray-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged5.jpeg') }}" alt="Background" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Struktur Organisasi</h1>
        <p class="text-blue-200">Susunan Pemerintah Desa Renged Tahun 2025</p>
    </div>
</div>

<div class="py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4">
        
        <!-- Bagan Struktur (Image Placeholder) -->
        <div class="mb-16 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Bagan Struktur Organisasi</h2>
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-8 flex items-center justify-center min-h-[400px]">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-gray-500 font-medium">Masukan Gambar Bagan Struktur Organisasi Disini</p>
                    <p class="text-xs text-gray-400 mt-1">(Upload via Admin Panel atau simpan di public/storage)</p>
                </div>
            </div>
        </div>

        <!-- List Pejabat Grid -->
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Pejabat Desa</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Kepala Desa -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 text-center group">
                <div class="h-64 bg-gray-200 overflow-hidden relative">
                    <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Kepala Desa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900">Nama Kepala Desa</h3>
                    <p class="text-blue-600 font-medium mb-2">Kepala Desa</p>
                    <p class="text-gray-500 text-sm">NIP. 19750101 200001 1 001</p>
                </div>
            </div>

            <!-- Sekretaris Desa -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 text-center group">
                <div class="h-64 bg-gray-200 overflow-hidden relative">
                    <div class="flex items-center justify-center h-full bg-gray-100 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900">Nama Sekretaris</h3>
                    <p class="text-blue-600 font-medium mb-2">Sekretaris Desa</p>
                    <p class="text-gray-500 text-sm">NIP. -</p>
                </div>
            </div>

             <!-- Kaur Keuangan -->
             <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 text-center group">
                <div class="h-64 bg-gray-200 overflow-hidden relative">
                    <div class="flex items-center justify-center h-full bg-gray-100 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900">Nama Kaur</h3>
                    <p class="text-blue-600 font-medium mb-2">Kaur Keuangan</p>
                    <p class="text-gray-500 text-sm">NIP. -</p>
                </div>
            </div>

             <!-- Kasi Pelayanan -->
             <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 text-center group">
                <div class="h-64 bg-gray-200 overflow-hidden relative">
                    <div class="flex items-center justify-center h-full bg-gray-100 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900">Nama Kasi</h3>
                    <p class="text-blue-600 font-medium mb-2">Kasi Pelayanan</p>
                    <p class="text-gray-500 text-sm">NIP. -</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
