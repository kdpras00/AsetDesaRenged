@extends('layouts.public')

@section('title', 'Statistik - Sistem Manajemen Aset Desa Renged')

@section('content')
<!-- Header -->
<div class="relative bg-blue-900 py-16 sm:py-24">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged7.jpeg') }}" alt="Data" class="h-full w-full object-cover object-center opacity-10">
        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center text-white">
        <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">Data Transparansi Desa</h1>
        <p class="mt-6 text-lg leading-8 text-blue-200">
            Statistik terkini mengenai pengelolaan aset dan pelayanan publik Desa Renged.
        </p>
    </div>
</div>

<!-- Key Metrics -->
<div class="py-12 bg-gray-50 dark:bg-gray-800">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-y-16 gap-x-8 text-center lg:grid-cols-3">
            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Total Nilai Aset Desa</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    Rp {{ number_format($stats['assets_value'], 0, ',', '.') }}
                </dd>
            </div>
            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Total Item Aset</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    {{ $stats['assets_count'] }}
                </dd>
            </div>
            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Surat Terbit</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    {{ $stats['letters_issued'] }}
                </dd>
            </div>
        </div>
    </div>
</div>

<!-- Charts / Visuals Section -->
<div class="py-16 bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl mb-8">Sebaran Kategori Aset</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($stats['asset_categories'] as $category)
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($category->description, 40) }}</p>
                    </div>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-800 font-bold">
                        {{ $category->assets_count }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-4">
                    @php
                        $percentage = $stats['assets_count'] > 0 ? ($category->assets_count / $stats['assets_count']) * 100 : 0;
                    @endphp
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-16 border-t border-gray-200 dark:border-gray-700 pt-16">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl mb-8">Partisipasi Warga</h2>
            <div class="bg-blue-600 rounded-2xl p-8 sm:p-12 shadow-xl overflow-hidden relative">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 opacity-10">
                    <svg width="400" height="400" fill="currentColor" viewBox="0 0 200 200"><path d="M45,-78C58.3,-69.3,69.1,-56.6,76.4,-42.6C83.7,-28.6,87.6,-13.3,86.4,1.4C85.2,16.2,78.9,30.3,69.9,42.4C60.9,54.5,49.2,64.6,36.4,72.3C23.6,80,9.7,85.3,-3.1,89.5C-15.9,93.8,-27.6,97,-39.6,94.3C-51.6,91.6,-63.9,83,-73.4,71.8C-82.9,60.6,-89.6,46.8,-91.8,32.3C-94,17.8,-91.7,2.6,-86.3,-10.8C-80.9,-24.2,-72.4,-35.8,-62.1,-45.5C-51.8,-55.2,-39.7,-63,-27.1,-71.4C-14.5,-79.8,-1.4,-88.8,11.3,-88.2C24,-87.6,48,-77.4,45,-78Z" transform="translate(100 100)" /></svg>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-white">
                    <div>
                        <h3 class="text-3xl font-bold">Warga Terdaftar</h3>
                        <p class="mt-2 text-blue-100">Jumlah warga yang telah memiliki akun digital desa.</p>
                    </div>
                    <div class="text-center">
                        <span class="block text-6xl font-bold">{{ $stats['warga_count'] }}</span>
                        <span class="text-sm uppercase tracking-wider text-blue-200">Akun Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
