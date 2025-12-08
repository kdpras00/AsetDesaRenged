@extends('layouts.app')

@section('title', 'Kelola Pengguna - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
             <p class="text-gray-500 text-sm">Manajemen akun pengguna sistem informasi desa.</p>
        </div>
        <a href="{{ route('operator.users.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center transition shadow hover:shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- Filters -->
    <div class="p-4 border-b border-gray-200 bg-white">
        <form action="{{ route('operator.users.index') }}" method="GET" class="flex items-center space-x-2">
             <label class="text-sm font-medium text-gray-700">Filter Role:</label>
             <select name="role" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                <option value="kepala_desa" {{ request('role') == 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
                <option value="warga" {{ request('role') == 'warga' ? 'selected' : '' }}>Warga</option>
            </select>
            @if(request('role'))
                <a href="{{ route('operator.users.index') }}" class="text-sm text-red-600 hover:underline ml-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Kontak / NIK</th>
                        <th class="px-6 py-3">Dibuat Pada</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mr-3 text-lg font-bold uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-base font-semibold text-gray-900">{{ $user->name }}</div>
                                    <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                         <td class="px-6 py-4">
                            @if($user->role == 'admin')
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-purple-200">Admin</span>
                            @elseif($user->role == 'operator')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-blue-200">Operator</span>
                            @elseif($user->role == 'kepala_desa')
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-200">Kades</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-gray-200">Warga</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $user->phone ?? '-' }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $user->nik ?? 'No NIK' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('operator.users.edit', $user) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-xs px-3 py-2 transition focus:outline-none focus:ring-4 focus:ring-yellow-300">
                                    Edit
                                </a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('operator.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-xs px-3 py-2 transition focus:outline-none focus:ring-4 focus:ring-red-300">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data pengguna ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
