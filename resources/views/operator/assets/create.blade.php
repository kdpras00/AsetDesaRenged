@extends('layouts.app')

@section('title', 'Tambah Aset - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('operator.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('operator.assets.index') }}" class="hover:text-blue-600">Kelola Aset</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Tambah Baru</span>
    </nav>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-xl font-bold text-gray-900">Form Input Aset Desa</h1>
            <p class="text-gray-500 text-sm mt-1">Lengkapi data inventarisasi aset desa di bawah ini.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('operator.assets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section 1: Informasi Dasar -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative">
                    <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">1</span>
                        Informasi Dasar
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama Aset -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Aset/Barang <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all placeholder-gray-400 focus:bg-white" 
                                    placeholder="Contoh: Laptop Asus ROG">
                            </div>
                        </div>

                        <!-- Kode Inventaris -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Kode Inventaris <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h-4v-4H8m13-4V4H3v7h2m12-6h-2m4 4h-2m0 4h-2m-2 4h-2m6 0v4h-4v-4m-4 0v4H9v-4m6 0h2m-2 4h2m-2-4v4m0 0h4m-4-2H9m0 0v2m0-2H7m2 0v-2"></path></svg>
                                </div>
                                <input type="text" name="code" value="{{ old('code') }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all placeholder-gray-400 focus:bg-white font-mono" 
                                    placeholder="INV-2025-001">
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <select name="category_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white appearance-none">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Jumlah Unit <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                </div>
                                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white" 
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail & Kondisi -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Detail & Kondisi
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi Lengkap</label>
                             <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                </div>
                                <textarea name="description" rows="3" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all placeholder-gray-400 focus:bg-white" 
                                    placeholder="Spesifikasi, warna, kelengkapan...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <!-- Kondisi -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Kondisi Aset <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <select name="condition" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white appearance-none">
                                    <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak_ringan" {{ old('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ old('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat (Afkir)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Lokasi Penempatan</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <input type="text" name="location" value="{{ old('location') }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all placeholder-gray-400 focus:bg-white" 
                                    placeholder="Contoh: Ruang Rapat Lt. 2">
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Aset</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">JPG, PNG (MAX. 2MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(this)" />
                                </label>
                            </div>
                            <div id="image-preview" class="mt-4 hidden">
                                <span class="text-sm text-gray-500 mb-2 block">Preview:</span>
                                <img id="preview-img" src="#" alt="Preview" class="h-32 w-auto rounded-lg shadow-sm border border-gray-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Data Perolehan -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">3</span>
                        Data Perolehan (Opsional)
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Tanggal Beli -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Pembelian</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white" >
                            </div>
                        </div>
                         <!-- Harga -->
                        <div>
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Harga Perolehan (Rp)</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold">Rp</span>
                                </div>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all placeholder-gray-400 focus:bg-white" 
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('operator.assets.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition focus:ring-4 focus:ring-gray-100">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl focus:ring-4 focus:ring-blue-300">Simpan Data Aset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
