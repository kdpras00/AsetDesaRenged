@extends('layouts.app')

@section('title', 'Ajukan Peminjaman - Desa Renged')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('warga.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('warga.loans.index') }}" class="hover:text-blue-600">Pinjam Aset</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Form Pengajuan</span>
    </nav>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-xl font-bold text-gray-900">Form Peminjaman Aset</h1>
            <p class="text-gray-500 text-sm mt-1">Silakan lengkapi formulir pengajuan peminjaman di bawah ini.</p>
        </div>

        <div class="p-8">
            <!-- Asset Info Card -->
            <div class="flex items-start bg-blue-50/50 p-6 rounded-xl border border-blue-100 mb-8 shadow-sm">
                @if($asset->image)
                    <img src="{{ Storage::url($asset->image) }}" class="w-20 h-20 rounded-lg object-cover border border-blue-200 mr-5 shadow-sm">
                @else
                    <div class="w-20 h-20 bg-blue-100 rounded-lg flex items-center justify-center text-blue-400 mr-5 border border-blue-200 shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $asset->name }}</h3>
                    <div class="flex items-center text-sm text-blue-700 font-medium mt-1">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded-full mr-2">{{ $asset->category->name ?? 'Umum' }}</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                         Stok Tersedia: <span class="font-bold text-gray-900 ml-1">{{ $asset->rentable_stock }} Unit</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('warga.loans.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">1</span>
                        Detail Peminjaman
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Tanggal Pinjam -->
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Pinjam <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="loan_date" value="{{ old('loan_date') }}" required min="{{ date('Y-m-d') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white">
                            </div>
                        </div>

                        <!-- Rencana Kembali -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Rencana Kembali <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="return_date" value="{{ old('return_date') }}" required min="{{ date('Y-m-d') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white">
                            </div>
                        </div>

                        <!-- Jumlah Pinjam -->
                         <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Jumlah Unit Dipinjam <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $asset->rentable_stock }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="1">
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded mr-2">Stok: {{ $asset->rentable_stock }}</span>
                                Maksimal yang dapat dipinjam.
                            </p>
                        </div>

                        <!-- Keperluan -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Keperluan Peminjaman <span class="text-red-500">*</span></label>
                             <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <textarea name="purpose" rows="4" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Jelaskan tujuan penggunaan aset ini...">{{ old('purpose') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('warga.loans.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition focus:ring-4 focus:ring-gray-100">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl focus:ring-4 focus:ring-blue-300">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
