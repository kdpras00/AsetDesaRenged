@extends('layouts.auth')

@section('title', 'Login - Desa Renged')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Desa Renged</h1>
            <p class="text-blue-100">Sistem Manajemen Aset Desa</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Masuk ke Akun Anda</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
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
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                        placeholder="nama@example.com">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                        placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ingat saya</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Masuk
                </button>

                <!-- Register Link -->
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline dark:text-blue-500">Daftar sekarang</a>
                </div>

                <!-- Back to Home -->
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:underline dark:text-gray-400">← Kembali ke beranda</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Test Credentials Info -->
    <div class="mt-6 p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur rounded-lg">
        <p class="text-xs text-gray-600 dark:text-gray-400 text-center mb-2 font-semibold">Akun untuk testing:</p>
        <div class="grid grid-cols-3 gap-2 text-xs">
            <div class="text-center">
                <p class="font-semibold text-blue-600">Kepala Desa</p>
                <p class="text-gray-600">kepaladesa@renged.id</p>
            </div>
            <div class="text-center">
                <p class="font-semibold text-green-600">Operator</p>
                <p class="text-gray-600">operator@renged.id</p>
            </div>
            <div class="text-center">
                <p class="font-semibold text-purple-600">Warga</p>
                <p class="text-gray-600">budi@example.com</p>
            </div>
        </div>
        <p class="text-xs text-gray-500 text-center mt-2">Password: <code class="bg-gray-200 px-2 py-1 rounded">password</code></p>
    </div>
</div>
@endsection
