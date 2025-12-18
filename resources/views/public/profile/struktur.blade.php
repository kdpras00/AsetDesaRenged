@extends('layouts.public')

@section('title', 'Struktur Organisasi - Website Resmi Desa Renged')

@section('content')
<div class="relative bg-blue-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Struktur Organisasi</h1>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto">Susunan Organisasi dan Tata Kerja Pemerintah Desa Renged Kecamatan Kresek Kabupaten Tangerang.</p>
    </div>
</div>

<div class="bg-white py-12">
    <div class="max-w-screen-xl mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-12 text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-500 md:ml-2">Profil Desa</span>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-900 md:ml-2 font-medium">Struktur Organisasi</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Digital Structure Chart -->
        <div class="mb-16 overflow-x-auto pb-8">
            <div class="min-w-[1000px] flex flex-col items-center">
                <!-- Kepala Desa -->
                <div class="flex flex-col items-center mb-8 relative z-10">
                    <div class="bg-blue-700 text-white rounded-lg shadow-lg p-4 w-64 text-center border-l-4 border-yellow-400 transform hover:scale-105 transition-transform duration-300">
                        <div class="font-bold text-sm opacity-80 mb-1">KEPALA DESA</div>
                        <div class="font-bold text-xl">WAWAN</div>
                    </div>
                    <div class="h-8 w-0.5 bg-gray-400"></div>
                </div>

                <!-- Sekretaris Desa -->
                <div class="flex flex-col items-center mb-12 relative z-10 w-full">
                    <!-- Garis Horizontal Penghubung ke Bawah -->
                    <div class="absolute top-0 h-0.5 bg-gray-400 w-1/2"></div>
                    
                    <div class="bg-blue-600 text-white rounded-lg shadow-md p-3 w-60 text-center border-l-4 border-yellow-400 transform hover:scale-105 transition-transform duration-300">
                        <div class="font-bold text-xs opacity-80 mb-1">SEKRETARIS DESA</div>
                        <div class="font-bold text-lg">DEVI FITRIA</div>
                    </div>
                    <div class="h-8 w-0.5 bg-gray-400"></div>
                    <!-- Garis Cabang Utama -->
                    <div class="h-0.5 bg-gray-400 w-[90%]"></div>
                </div>

                <!-- Three Main Columns: Kaur, Kasie, Kadus -->
                <div class="grid grid-cols-3 gap-8 w-full px-4">
                    
                    <!-- Kolom Kepala Urusan (Kaur) -->
                    <div class="flex flex-col items-center space-y-6 relative">
                        <div class="h-6 w-0.5 bg-gray-400 absolute -top-6"></div>
                        <h3 class="font-bold text-gray-500 uppercase tracking-widest text-sm mb-2">Urusan (Staff)</h3>
                        
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-blue-600 font-bold mb-1">KAUR UMUM</div>
                            <div class="font-bold text-gray-800">ANWAR</div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-blue-600 font-bold mb-1">KAUR KEUANGAN</div>
                            <div class="font-bold text-gray-800">SAPUAH</div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-blue-600 font-bold mb-1">KAUR PERENCANAAN</div>
                            <div class="font-bold text-gray-800">DENI RAY</div>
                        </div>
                    </div>

                    <!-- Kolom Kepala Seksi (Kasie) -->
                    <div class="flex flex-col items-center space-y-6 relative">
                        <div class="h-6 w-0.5 bg-gray-400 absolute -top-6"></div>
                        <h3 class="font-bold text-gray-500 uppercase tracking-widest text-sm mb-2">Seksi (Pelaksana)</h3>

                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-green-600 font-bold mb-1">KASIE PEMERINTAHAN</div>
                            <div class="font-bold text-gray-800">AEN SUHENDI</div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-green-600 font-bold mb-1">KASIE PELAYANAN</div>
                            <div class="font-bold text-gray-800">SITI NENENG NURSAIDAH</div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-green-600 font-bold mb-1">KASIE PEMBERDAYAAN</div>
                            <div class="font-bold text-gray-800">NURDIN</div>
                        </div>
                    </div>

                    <!-- Kolom Kepala Dusun / Lingkungan / Kejaroan -->
                    <div class="flex flex-col items-center space-y-6 relative">
                        <div class="h-6 w-0.5 bg-gray-400 absolute -top-6"></div>
                        <h3 class="font-bold text-gray-500 uppercase tracking-widest text-sm mb-2">Kewilayahan</h3>

                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-purple-600 font-bold mb-1">KEJAROAN I</div>
                            <div class="font-bold text-gray-800">SULAEMAN</div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-3 w-full max-w-[280px] text-center hover:shadow-md transition-shadow">
                            <div class="text-xs text-purple-600 font-bold mb-1">KEJAROAN II</div>
                            <div class="font-bold text-gray-800">DIDI JAHUDI</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Document Preview -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-l-4 border-blue-600 pl-4">Dokumen Resmi</h2>
        <div class="bg-gray-100 p-4 rounded-lg">
            <div class="flex flex-col items-center">
                <img src="{{ asset('storage/images/struktur-organisasi.jpg') }}" alt="Dokumen Struktur Organisasi" class="max-w-full h-auto rounded shadow-lg border border-gray-300">
                <p class="mt-2 text-sm text-gray-500">Lampiran Surat Keputusan Kepala Desa Renged tentang Susunan Organisasi Pemerintah Desa.</p>
            </div>
        </div>

    </div>
</div>
@endsection
