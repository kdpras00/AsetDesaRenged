@extends('layouts.app')

@section('title', 'Katalog Aset - Desa Renged')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header & Tabs -->
    <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Pinjam Aset Desa</h1>
             <p class="text-gray-500 text-sm">Cari dan ajukan peminjaman aset untuk keperluan warga.</p>
        </div>
        <div class="flex space-x-2 bg-gray-200 p-1 rounded-lg">
            <a href="{{ route('warga.loans.index', ['view' => 'catalog']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('view', 'catalog') == 'catalog' ? 'bg-white text-gray-900 shadow' : 'text-gray-500 hover:text-gray-900' }}">
                Katalog Aset
            </a>
            <a href="{{ route('warga.loans.index', ['view' => 'history']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('view') == 'history' ? 'bg-white text-gray-900 shadow' : 'text-gray-500 hover:text-gray-900' }}">
                Riwayat Saya
            </a>
        </div>
    </div>

    @if(request('view') == 'history')
        @include('warga.loans.history')
    @else
        <!-- Catalog Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($assets as $asset)
                <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if($asset->image)
                            <img src="{{ Storage::url($asset->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $asset->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                         <div class="absolute top-2 right-2 flex flex-col space-y-1">
                             <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow">{{ $asset->category->name ?? 'Umum' }}</span>
                         </div>
                    </div>
                    
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-900 text-lg mb-1 group-hover:text-blue-600 transition-colors">{{ $asset->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-1">{{ $asset->description ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <div class="flex justify-between items-center mt-auto border-t border-gray-100 pt-4">
                            <div class="text-xs text-gray-500">
                                Stok: <span class="font-bold text-gray-900">{{ $asset->quantity }} Unit</span>
                            </div>
                            <a href="{{ route('warga.loans.create', $asset) }}" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center transition shadow-md hover:shadow-lg">
                                Pinjam
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aset tersedia</h3>
                    <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti atau hubungi operator.</p>
                </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $assets->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
