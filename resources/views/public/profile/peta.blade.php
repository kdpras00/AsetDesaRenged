@extends('layouts.public')

@section('title', 'Peta Desa - Website Resmi Desa Renged')

@section('content')
<div class="relative bg-blue-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Peta Wilayah Desa</h1>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto">Gambaran geografis dan administratif wilayah Desa Renged, Kecamatan Kresek, Kabupaten Tangerang.</p>
    </div>
</div>

<div class="bg-white py-12">
    <div class="max-w-screen-xl mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-gray-500 text-sm" aria-label="Breadcrumb">
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
                        <span class="ml-1 text-gray-900 md:ml-2 font-medium">Peta Desa</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 shadow-sm">
            <div class="flex flex-col items-center">
                <div class="relative w-full overflow-hidden rounded-lg shadow-lg border-4 border-white">
                    <img src="{{ asset('storage/images/peta-desa.png') }}" class="w-full h-auto object-contain hover:scale-105 transition-transform duration-500 cursor-zoom-in" onclick="window.open(this.src, '_blank')" alt="Peta Desa Renged">
                </div>
                <p class="mt-4 text-sm text-gray-500 italic">Klik pada peta untuk melihat ukuran penuh.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
                <div>
                     <h3 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Batas Wilayah</h3>
                     <ul class="space-y-2 text-gray-700">
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="font-medium">Utara</span>
                            <span>Desa Kresek</span>
                        </li>
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="font-medium">Timur</span>
                            <span>Desa Talok</span>
                        </li>
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="font-medium">Selatan</span>
                            <span>Desa Jengkol</span>
                        </li>
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="font-medium">Barat</span>
                            <span>Irigasi / Persawahan</span>
                        </li>
                     </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-blue-600 pl-3">Keterangan Peta</h3>
                    <ul class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                        <li class="flex items-center space-x-2"><span class="w-3 h-3 bg-gray-800 rounded-full"></span> <span>Jalan Utama</span></li>
                        <li class="flex items-center space-x-2"><span class="w-3 h-3 bg-blue-500 rounded-full"></span> <span>Irigasi / Sungai</span></li>
                        <li class="flex items-center space-x-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> <span>Persawahan</span></li>
                        <li class="flex items-center space-x-2"><span class="w-3 h-3 bg-yellow-500 rounded-full"></span> <span>Perkampungan</span></li>
                        <li class="flex items-center space-x-2"><span class="w-3 h-3 bg-orange-500 rounded-full"></span> <span>Layanan Publik</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
