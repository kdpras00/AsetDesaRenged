@extends('layouts.auth')

@section('title', 'Pendaftaran Warga - Website Resmi Desa Renged')

@section('content')
<div class="mb-8 text-center">
    <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Akun Warga</h2>
    <p class="text-gray-500 text-sm mt-2">Isi data diri Anda sesuai KTP untuk akses layanan digital.</p>
</div>

@if ($errors->any())
    <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200" role="alert">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Nama Lengkap -->
        <div class="md:col-span-2">
            <label for="name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap (Sesuai KTP)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none" placeholder="Contoh: Budi Santoso">
            </div>
        </div>

        <!-- NIK -->
        <div>
            <label for="nik" class="block mb-2 text-sm font-semibold text-gray-700">NIK (16 Digit)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </div>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none" placeholder="360...">
            </div>
        </div>



        <!-- No. HP -->
        <div>
            <label for="phone" class="block mb-2 text-sm font-semibold text-gray-700">Nomor WhatsApp</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required maxlength="13" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 outline-none" placeholder="0812...">
            </div>
        </div>



        <!-- Email -->
        <div>
            <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none" placeholder="email@contoh.com">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 outline-none" placeholder="••••••••">
                <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-show-password', 'eye-icon-hide-password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg id="eye-icon-show-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg id="eye-icon-hide-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
        </div>

        <!-- Confirm PW -->
        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 outline-none" placeholder="••••••••">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-show-confirmation', 'eye-icon-hide-confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg id="eye-icon-show-confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg id="eye-icon-hide-confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
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
    </div>

    <div class="pt-4">
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all shadow-md hover:shadow-lg">
            DAFTAR AKUN
        </button>
    </div>

    <div class="text-sm font-medium text-gray-500 text-center mt-6">
        Sudah terdaftar? <a href="{{ route('login') }}" class="text-blue-700 font-bold hover:underline">Masuk Sekarang</a>
    </div>
</form>
@endsection
