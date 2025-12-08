@extends('layouts.auth')

@section('title', 'Login - Website Resmi Desa Renged')

@section('content')
<div class="mb-8 text-center text-gray-500 text-sm">
    Silakan masuk untuk mengakses layanan mandiri.
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

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email -->
    <div>
        <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-colors" 
                placeholder="nama@email.com">
        </div>
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <input type="password" name="password" id="password" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-colors" 
                placeholder="••••••••">
        </div>
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            </div>
            <label for="remember" class="ml-2 text-sm font-medium text-gray-600">Ingat saya</label>
        </div>
        <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all shadow-md hover:shadow-lg">
        MASUK SISTEM
    </button>

    <!-- Register Link -->
    <div class="text-sm font-medium text-gray-500 text-center mt-6">
        Belum memiliki akun warga? <br><a href="{{ route('register') }}" class="text-blue-700 font-bold hover:underline">Daftar Akun Baru</a>
    </div>

    <div class="mt-8 pt-8 border-t border-gray-100 text-center">
         <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600 text-sm flex items-center justify-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</form>
@endsection
