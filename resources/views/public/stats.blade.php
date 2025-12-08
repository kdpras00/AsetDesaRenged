@extends('layouts.public')

@section('title', 'Statistik - Website Resmi Desa Renged')

@section('content')
<!-- Page Header -->
<div class="relative bg-gray-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged7.jpeg') }}" alt="Background" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Statistik Desa</h1>
        <p class="text-blue-200">Data transparansi dan akuntabilitas Desa Renged</p>
    </div>
</div>

<div class="bg-white py-12">
    <div class="max-w-screen-xl mx-auto px-4">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm text-center">
                <div class="text-sm text-gray-500 uppercase tracking-wider mb-2">Total Nilai Aset</div>
                <div class="text-2xl font-bold text-blue-700">Rp {{ number_format($stats['assets_value'], 0, ',', '.') }}</div>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm text-center">
                <div class="text-sm text-gray-500 uppercase tracking-wider mb-2">Jumlah Aset</div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['assets_count'] }} <span class="text-sm font-normal text-gray-400">Item</span></div>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm text-center">
                <div class="text-sm text-gray-500 uppercase tracking-wider mb-2">Layanan Surat</div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['letters_issued'] }} <span class="text-sm font-normal text-gray-400">Terbit</span></div>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm text-center">
                <div class="text-sm text-gray-500 uppercase tracking-wider mb-2">Warga Terdaftar</div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['warga_count'] }} <span class="text-sm font-normal text-gray-400">Akun</span></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Asset Chart (Simple Bars) -->
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-6 pb-4 border-b">Komposisi Aset Desa</h3>
                <div class="space-y-6">
                    @foreach($stats['asset_categories'] as $category)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                            <span class="text-sm font-medium text-gray-700">{{ $category->assets_count }} Unit</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                             @php
                                $percentage = $stats['assets_count'] > 0 ? ($category->assets_count / $stats['assets_count']) * 100 : 0;
                            @endphp
                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- APBDes (Static Placeholder for now) -->
             <div class="lg:col-span-1 bg-blue-50 rounded-lg border border-blue-100 p-6">
                <h3 class="font-bold text-xl text-blue-900 mb-6 pb-4 border-b border-blue-200">APBDes 2024</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-blue-800 mb-1">Pendapatan Desa</div>
                        <div class="w-full bg-blue-200 rounded-full h-8 relative overflow-hidden">
                             <div class="bg-green-500 h-full flex items-center px-3 text-xs font-bold text-white whitespace-nowrap" style="width: 85%">Rp 1.250.000.000</div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-blue-800 mb-1">Belanja Desa</div>
                        <div class="w-full bg-blue-200 rounded-full h-8 relative overflow-hidden">
                             <div class="bg-orange-500 h-full flex items-center px-3 text-xs font-bold text-white whitespace-nowrap" style="width: 70%">Rp 980.000.000</div>
                        </div>
                    </div>
                     <div>
                        <div class="text-sm text-blue-800 mb-1">Pembiayaan</div>
                        <div class="w-full bg-blue-200 rounded-full h-8 relative overflow-hidden">
                             <div class="bg-blue-500 h-full flex items-center px-3 text-xs font-bold text-white whitespace-nowrap" style="width: 90%">Rp 50.000.000</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-sm text-blue-800 text-center">
                    * Data per Bulan Desember 2024
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
