@extends('layouts.auth')

@section('title', 'Reset Password - Website Resmi Desa Renged')

@section('content')
<div class="mb-8 text-center text-gray-500 text-sm">
    Buat password baru Anda.
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

<form method="POST" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- Email -->
    <div>
        <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required autofocus
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-colors" 
                placeholder="nama@email.com">
        </div>
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password Baru</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <input type="password" name="password" id="password" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-colors" 
                placeholder="••••••••">
        </div>
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 outline-none transition-colors" 
                placeholder="••••••••">
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all shadow-md hover:shadow-lg">
        RESET PASSWORD
    </button>
</form>
@endsection
