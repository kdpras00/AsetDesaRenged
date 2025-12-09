@extends('layouts.public')

@section('title', 'Visi & Misi - Website Resmi Desa Renged')

@section('content')
<!-- Page Header -->
<div class="relative bg-gray-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged3.jpeg') }}" alt="Background" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Visi & Misi</h1>
        <p class="text-blue-200">Arah pembangunan dan cita-cita luhur Pemerintah Desa Renged</p>
    </div>
</div>

<div class="py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Visi -->
            <div>
                <div class="bg-blue-50 rounded-2xl p-8 border border-blue-100 h-full">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center text-white mb-6 transform rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-blue-900 mb-6">Visi</h2>
                    <p class="text-xl text-gray-700 italic font-medium leading-relaxed">
                        "Terwujudnya Desa Renged yang Maju, Mandiri, Sejahtera, dan Berakhlak Mulia melalui Tata Kelola Pemerintahan yang Bersih dan Transparan."
                    </p>
                </div>
            </div>

            <!-- Misi -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 pl-4 border-l-4 border-blue-600">Misi</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mt-1">1</span>
                        <p class="ml-4 text-gray-600 text-lg">Meningkatkan kualitas pelayanan publik yang cepat, tepat, dan transparan berbasis teknologi informasi.</p>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mt-1">2</span>
                        <p class="ml-4 text-gray-600 text-lg">Meningkatkan pembangunan infrastruktur desa yang merata dan berkelanjutan.</p>
                    </li>
                     <li class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mt-1">3</span>
                        <p class="ml-4 text-gray-600 text-lg">Memberdayakan ekonomi masyarakat melalui BUMDes dan UMKM.</p>
                    </li>
                     <li class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mt-1">4</span>
                        <p class="ml-4 text-gray-600 text-lg">Mewujudkan kehidupan masyarakat yang aman, tentram, dan agamis.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
