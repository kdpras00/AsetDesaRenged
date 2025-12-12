@extends('layouts.app')

@section('title', 'Tambah Pengguna - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('operator.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('operator.users.index') }}" class="hover:text-blue-600">Kelola Pengguna</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Tambah Baru</span>
    </nav>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-xl font-bold text-gray-900">Form Tambah Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk administrasi atau warga desa.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('operator.users.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative">
                    <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">1</span>
                        Informasi Akun
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Nama Lengkap">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="email@contoh.com">
                            </div>
                        </div>

                        <!-- Role -->
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Role Pengguna <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <select name="role" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white appearance-none">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="warga" {{ old('role') == 'warga' ? 'selected' : '' }}>Warga</option>
                                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                                    <option value="kepala_desa" {{ old('role') == 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Keamanan
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Password -->
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input type="password" name="password" id="password" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-show-password', 'eye-icon-hide-password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg id="eye-icon-show-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg id="eye-icon-hide-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>
                        <!-- Konfirmsi Password -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Ulangi password">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-show-confirmation', 'eye-icon-hide-confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg id="eye-icon-show-confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg id="eye-icon-hide-confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePasswordVisibility(fieldId, iconShowId, iconHideId) {
                        const input = document.getElementById(fieldId);
                        const iconShow = document.getElementById(iconShowId);
                        const iconHide = document.getElementById(iconHideId);
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            iconShow.classList.add('hidden');
                            iconHide.classList.remove('hidden');
                        } else {
                            input.type = 'password';
                            iconShow.classList.remove('hidden');
                            iconHide.classList.add('hidden');
                        }
                    }
                </script>

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">3</span>
                        Biodata & Kontak
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- NIK -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400 font-mono" placeholder="16 digit NIK">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nomor Telepon</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C7.82 21 2 15.18 2 5V3z"></path></svg>
                                </div>
                                <input type="text" name="phone" value="{{ old('phone') }}" maxlength="13" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                             <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                     <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <textarea name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Jalan, RT/RW, Dusun...">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('operator.users.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition focus:ring-4 focus:ring-gray-100">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl focus:ring-4 focus:ring-blue-300">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
