@extends('layouts.public')

@section('title', 'Layanan - Website Resmi Desa Renged')

@section('content')
<!-- Page Header -->
<div class="relative bg-gray-900 py-16">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged6.jpeg') }}" alt="Background" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Layanan Desa</h1>
        <p class="text-blue-200">Katalog layanan administrasi dan publik Desa Renged</p>
    </div>
</div>

<div class="bg-white py-12">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Sidebar Filters (Optional/Static) -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 sticky top-24">
                    <h3 class="font-bold text-lg mb-4 text-gray-900 border-b pb-2">Kategori Layanan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="block px-3 py-2 bg-blue-50 text-blue-700 font-medium rounded">Semua Layanan</a></li>
                        <li><a href="#" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">Administrasi Kependudukan</a></li>
                        <li><a href="#" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">Peminjaman Aset</a></li>
                        <li><a href="#" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">Perizinan Usaha</a></li>
                        <li><a href="#" class="block px-3 py-2 text-gray-600 hover:bg-gray-100 rounded">Bantuan Sosial</a></li>
                    </ul>

                    <div class="mt-8 bg-blue-600 rounded-lg p-6 text-white text-center">
                        <h4 class="font-bold mb-2">Butuh Bantuan?</h4>
                        <p class="text-sm text-blue-100 mb-4">Hubungi operator desa kami untuk panduan layanan.</p>
                        <a href="#" class="inline-block bg-white text-blue-600 px-4 py-2 rounded text-sm font-bold">Chat WhatsApp</a>
                    </div>
                </div>
            </div>

            <!-- Service List -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Service Item 1 -->
                <div class="flex flex-col sm:flex-row bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="sm:w-48 h-48 sm:h-auto shrink-0">
                        <img src="{{ asset('storage/images/background-renged2.jpeg') }}" class="w-full h-full object-cover" alt="Service">
                    </div>
                    <div class="p-6 flex flex-col justify-between w-full">
                        <div>
                            <div class="text-xs font-bold text-blue-600 uppercase mb-1">Inventaris</div>
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Peminjaman Aset Desa</h3>
                            <p class="text-gray-600 text-sm mb-4">Layanan peminjaman tenda, kursi, dan peralatan sound system untuk kegiatan warga.</p>
                        </div>
                        <div class="flex items-center justify-between border-t pt-4 mt-2">
                             <span class="text-xs text-gray-500">Estimasi: 1 Hari Kerja</span>
                             <a href="#" class="text-blue-600 font-medium text-sm hover:underline">Ajukan Sekarang &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Service Item 2 -->
                 <div class="flex flex-col sm:flex-row bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="sm:w-48 h-48 sm:h-auto shrink-0">
                        <img src="{{ asset('storage/images/background-renged3.jpeg') }}" class="w-full h-full object-cover" alt="Service">
                    </div>
                    <div class="p-6 flex flex-col justify-between w-full">
                        <div>
                            <div class="text-xs font-bold text-green-600 uppercase mb-1">Kependudukan</div>
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Surat Keterangan Domisili</h3>
                            <p class="text-gray-600 text-sm mb-4">Penerbitan surat keterangan domisili untuk persyaratan administrasi, bank, atau sekolah.</p>
                        </div>
                        <div class="flex items-center justify-between border-t pt-4 mt-2">
                             <span class="text-xs text-gray-500">Estimasi: Langsung Jadi</span>
                             <a href="#" class="text-blue-600 font-medium text-sm hover:underline">Buat Surat &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Service Item 3 -->
                 <div class="flex flex-col sm:flex-row bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="sm:w-48 h-48 sm:h-auto shrink-0">
                        <img src="{{ asset('storage/images/background-renged5.jpeg') }}" class="w-full h-full object-cover" alt="Service">
                    </div>
                    <div class="p-6 flex flex-col justify-between w-full">
                        <div>
                            <div class="text-xs font-bold text-purple-600 uppercase mb-1">Usaha</div>
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Surat Keterangan Usaha (SKU)</h3>
                            <p class="text-gray-600 text-sm mb-4">Surat keterangan memiliki usaha untuk persyaratan KUR atau kredit perbankan.</p>
                        </div>
                        <div class="flex items-center justify-between border-t pt-4 mt-2">
                             <span class="text-xs text-gray-500">Estimasi: 1 Hari Kerja</span>
                             <a href="#" class="text-blue-600 font-medium text-sm hover:underline">Buat Surat &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
