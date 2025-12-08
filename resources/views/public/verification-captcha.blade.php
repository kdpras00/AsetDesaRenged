@extends('layouts.public')

@section('title', 'Validasi Dokumen - Desa Renged')

@section('content')
<div class="relative min-h-[500px] flex items-center justify-center py-20 bg-gray-100">
    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/images/background-renged4.jpeg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
    </div>

    <!-- Captcha Box -->
    <div class="relative z-10 w-full max-w-md px-4">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-white p-6 border-b border-gray-100 text-center">
                 <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-12 w-auto mx-auto mb-2" alt="Logo">
                 <h2 class="text-xl font-bold text-gray-800">Validasi Akses Dokumen</h2>
                 <p class="text-sm text-gray-500">Sistem Verifikasi Digital Desa Renged</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form action="{{ route('verification.captcha.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="hash" value="{{ $hash }}">

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2 text-center" for="captcha">
                            Kode Keamanan (CAPTCHA) <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Captcha Image -->
                        <div class="flex flex-col items-center justify-center mb-4 gap-2">
                             <div class="border rounded p-1 bg-gray-50 inline-block overflow-hidden">
                                {!! captcha_img('flat') !!}
                            </div>
                            <button type="button" onclick="refreshCaptcha()" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Refresh Captcha
                            </button>
                        </div>

                        <!-- Input -->
                        <div class="relative">
                            <input type="text" name="captcha" id="captcha" 
                                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('captcha') ? 'border-red-500 focus:ring-red-200' : 'border-gray-300' }}"
                                placeholder="Masukkan kode di atas..." required autocomplete="off">
                            
                            @error('captcha')
                                <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Tampilkan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    function refreshCaptcha() {
        fetch('{{ route("captcha.refresh") }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.border.rounded.p-1.bg-gray-50').innerHTML = data.img;
            });
    }
</script>
@endpush
@endsection
