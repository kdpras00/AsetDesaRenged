@extends('layouts.app')

@section('title', 'Layanan Surat - Desa Renged')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header & Tabs -->
    <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Layanan Surat Online</h1>
             <p class="text-gray-500 text-sm">Ajukan permohonan surat keterangan dan administrasi desa secara online.</p>
        </div>
        <div class="flex space-x-2 bg-gray-200 p-1 rounded-lg">
            <a href="{{ route('warga.letters.index', ['view' => 'catalog']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('view', 'catalog') == 'catalog' ? 'bg-white text-gray-900 shadow' : 'text-gray-500 hover:text-gray-900' }}">
                Jenis Surat
            </a>
            <a href="{{ route('warga.letters.index', ['view' => 'history']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('view') == 'history' ? 'bg-white text-gray-900 shadow' : 'text-gray-500 hover:text-gray-900' }}">
                Riwayat Pengajuan
            </a>
        </div>
    </div>

    <!-- Letters Grid -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($letterTypes as $type)
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $type->name }}</h3>
                <p class="text-sm text-gray-500 mb-4 flex-1">{{ $type->description ?? 'Surat keterangan resmi dari pemerintah desa.' }}</p>
                
                @php
                    $userAge = \Carbon\Carbon::parse(auth()->user()->birth_date)->age;
                @endphp

                @if($userAge < 17)
                    <button onclick="Swal.fire({
                        icon: 'error',
                        title: 'Usia Belum Mencukupi',
                        text: 'Maaf, Anda harus berusia minimal 17 tahun untuk mengajukan surat ini. Usia Anda saat ini: {{ $userAge }} tahun.',
                        confirmButtonColor: '#d33'
                    })" class="w-full inline-flex justify-center items-center text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Terkunci (17+)
                    </button>
                @else
                    <a href="{{ route('warga.letters.create', $type) }}" class="w-full inline-flex justify-center items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition shadow hover:shadow-md">
                        Ajukan Sekarang
                    </a>
                @endif
            </div>
            @empty
            <div class="col-span-full py-12 text-center">
                <p class="text-gray-500">Belum ada layanan surat tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
