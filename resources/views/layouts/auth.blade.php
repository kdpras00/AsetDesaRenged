<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Akses Layanan - Desa Renged')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex">
        
        <!-- Left Side - Official Branding / Info -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-blue-900 overflow-hidden">
            <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="absolute inset-0 w-full h-full object-cover opacity-30" alt="Background Desa">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/40 to-transparent"></div>
            
            <div class="relative z-10 p-12 flex flex-col justify-between w-full">
                <!-- Top Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-12 w-auto" alt="Logo">
                    <div>
                        <h1 class="text-white font-bold text-xl leading-none">PEMERINTAH DESA RENGED</h1>
                        <p class="text-blue-200 text-sm">Kecamatan Kresek, Kabupaten Tangerang</p>
                    </div>
                </div>

                <!-- Middle Content -->
                <div class="mb-12">
                    <h2 class="text-4xl font-bold text-white mb-6">Sistem Pelayanan Digital <br>Terpadu Satu Pintu</h2>
                    <p class="text-lg text-blue-100 max-w-lg leading-relaxed">
                        Nikmati kemudahan akses layanan administrasi desa secara online. Cepat, Transparan, dan Akuntabel.
                    </p>
                    <div class="mt-8 flex gap-4">
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Layanan 24 Jam</span>
                        </div>
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Verifikasi Digital</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="text-blue-300 text-sm">
                    &copy; 2025 Pemerintah Desa Renged. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>

        <!-- Right Side - Auth Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="max-w-md w-full">
                <div class="text-center mb-10 lg:hidden">
                    <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-16 w-auto mx-auto mb-4" alt="Logo">
                    <h2 class="text-2xl font-bold text-gray-900">Desa Renged</h2>
                </div>

                @yield('content')
            </div>
        </div>

    </div>

</body>
</html>
