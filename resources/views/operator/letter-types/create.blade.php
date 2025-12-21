@extends('layouts.app')

@section('title', isset($letterType) ? 'Edit Jenis Surat' : 'Tambah Jenis Surat')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('operator.letter-types.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Manajemen Surat
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h1 class="text-xl font-bold text-gray-800">
                    {{ isset($letterType) ? 'Edit Jenis Surat' : 'Tambah Jenis Surat Baru' }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ isset($letterType) ? 'Perbarui informasi jenis surat.' : 'Buat jenis surat baru untuk layanan mandiri.' }}
                </p>
            </div>
            
            <form action="{{ isset($letterType) ? route('operator.letter-types.update', $letterType->id) : route('operator.letter-types.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                @if(isset($letterType))
                    @method('PUT')
                @endif

                <!-- Nama Surat -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Surat</label>
                    <input type="text" name="name" value="{{ old('name', $letterType->name ?? '') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Contoh: Surat Keterangan Domisili">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Surat -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Kode Klasifikasi</label>
                    <input type="text" name="code" value="{{ old('code', $letterType->code ?? '') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Contoh: 470">
                    <p class="mt-1 text-xs text-gray-500">Kode klasifikasi surat sesuai aturan administrasi desa.</p>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi / Persyaratan</label>
                    <textarea name="description" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Jelaskan kegunaan surat ini">{{ old('description', $letterType->description ?? '') }}</textarea>
                </div>
                
                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
                        {{ isset($letterType) ? 'Simpan Perubahan' : 'Buat Jenis Surat' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
