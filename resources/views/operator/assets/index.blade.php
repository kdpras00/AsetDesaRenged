@extends('layouts.app')

@section('title', 'Kelola Aset - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Manajemen Aset Desa</h1>
             <p class="text-gray-500 text-sm">Daftar inventaris milik Desa Renged.</p>
        </div>
        <a href="{{ route('operator.assets.create') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Aset
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto p-6">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">FOTO</th>
                    <th scope="col" class="px-6 py-3">KODE & NAMA</th>
                    <th scope="col" class="px-6 py-3">KATEGORI</th>
                    <th scope="col" class="px-6 py-3">KONDISI</th>
                    <th scope="col" class="px-6 py-3">JUMLAH</th>
                    <th scope="col" class="px-6 py-3 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($assets as $asset)
                <tr class="bg-white hover:bg-gray-50 transition-colors cursor-pointer">
                    <td class="px-6 py-4">
                        @if($asset->image)
                            <img src="{{ Storage::url($asset->image) }}" class="w-12 h-12 rounded object-cover border border-gray-200" alt="{{ $asset->name }}">
                        @else
                             <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                             </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $asset->name }}</div>
                        <div class="text-xs text-blue-600 font-mono">{{ $asset->code }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                            {{ $asset->category ? $asset->category->name : 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($asset->condition == 'baik')
                            <span class="text-green-600 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Baik
                            </span>
                        @elseif($asset->condition == 'rusak_ringan')
                            <span class="text-yellow-600 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span> Rusak Ringan
                            </span>
                        @else
                            <span class="text-red-600 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Rusak Berat
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                        {{ $asset->quantity }} <span class="text-gray-400 font-normal text-xs">Unit</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                             <a href="{{ route('operator.assets.edit', $asset) }}" class="text-yellow-500 hover:text-yellow-700 p-1 mb-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form id="delete-form-{{ $asset->id }}" action="{{ route('operator.assets.destroy', $asset) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $asset->id }}')" class="text-red-500 hover:text-red-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-gray-50">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-lg font-medium">Belum ada data aset.</p>
                        <p class="text-sm">Mulai dengan menambahkan aset baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $assets->links() }}
        </div>
    </div>
</div>
@endsection
