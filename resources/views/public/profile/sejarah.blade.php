@extends('layouts.public')

@section('title', 'Sejarah Desa - Website Resmi Desa Renged')

@section('content')
<!-- Page Header -->
<div class="relative bg-gray-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Background" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Sejarah Desa</h1>
        <p class="text-blue-200">Menelusuri jejak perjalanan Desa Renged dari masa ke masa</p>
    </div>
</div>

<div class="py-16 bg-white">
    <div class="max-w-screen-lg mx-auto px-4">
        <div class="prose prose-lg text-gray-600 mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Asal Usul Nama Desa Renged</h2>
            <p class="mb-6">
                Desa Renged merupakan salah satu desa yang terletak di Kecamatan Kresek, Kabupaten Tangerang. 
                Nama "Renged" dipercaya berasal dari kata dalam bahasa Sunda atau istilah lokal yang memiliki makna historis 
                yang berkaitan dengan kondisi geografis atau peristiwa masa lampau di wilayah ini.
            </p>

            <div class="my-8 rounded-lg overflow-hidden shadow-lg">
                 <img src="{{ asset('storage/images/background-renged2.jpeg') }}" alt="Sejarah Desa" class="w-full h-96 object-cover">
                 <p class="text-sm text-center text-gray-500 italic p-2 bg-gray-50">Kantor Desa Renged Tempo Dulu (Ilustrasi)</p>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-4">Masa Pembentukan</h2>
            <p class="mb-6">
                Pada awalnya, wilayah ini adalah bagian dari kesatuan adat yang lebih besar sebelum akhirnya dimekarkan menjadi desa administratif.
                Seiring berjalannya waktu, Desa Renged terus berkembang menjadi pusat pemukiman yang padat dengan berbagai potensi pertanian dan sumber daya manusia.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mb-4">Perkembangan Hingga Kini</h2>
            <p class="mb-6">
                Saat ini, Desa Renged terus berbenah di bawah kepemimpinan Kepala Desa yang visioner. 
                Pembangunan infrastruktur jalan, fasilitas kesehatan, dan pelayanan publik berbasis digital menjadi prioritas utama 
                untuk meningkatkan kesejahteraan masyarakat.
            </p>
        </div>
    </div>
</div>
@endsection
