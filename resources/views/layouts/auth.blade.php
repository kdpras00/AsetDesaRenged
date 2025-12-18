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
        <div class="hidden lg:flex lg:w-1/2 relative bg-blue-900 overflow-hidden flex-col justify-between">
            <div class="absolute inset-0">
                <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-40" alt="Background Desa">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/60 to-transparent"></div>
            </div>
            
            <div class="relative z-10 p-12 flex flex-col h-full justify-between">
                <!-- Top Logo -->
                <div>
                     <!-- Badge -->
                    <div class="inline-flex items-center bg-yellow-500/10 border border-yellow-500/30 rounded-full px-3 py-1 mb-6 backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-yellow-100/90 text-xs font-semibold tracking-wider uppercase">Website Resmi Pemerintah</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-14 w-auto drop-shadow-md" alt="Logo">
                        <div>
                            <h1 class="text-white font-bold text-2xl leading-none tracking-tight">DESA RENGED</h1>
                            <p class="text-blue-200 text-sm mt-1 font-medium">Kabupaten Tangerang</p>
                        </div>
                    </div>
                </div>

                <!-- Middle Content -->
                <div class="my-auto">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight drop-shadow-sm">
                        Sistem Pelayanan <br>
                        <span class="text-yellow-400">Digital Terpadu</span>
                    </h2>
                    <p class="text-lg text-blue-100 max-w-md leading-relaxed font-light">
                        Akses layanan administrasi desa dengan mudah, cepat, dan transparan dari mana saja.
                    </p>
                    
                    <div class="mt-8 space-y-4">
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 rounded-full bg-blue-800/50 flex items-center justify-center mr-3 border border-blue-700">
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="font-medium">Layanan Mandiri 24 Jam</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 rounded-full bg-blue-800/50 flex items-center justify-center mr-3 border border-blue-700">
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="font-medium">Validasi Data Otomatis</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="text-blue-300/60 text-xs font-light tracking-wide">
                    &copy; 2025 Pemerintah Desa Renged. <br>Melayani dengan Hati, Membangun dengan Aksi.
                </div>
            </div>
            
             <!-- Decorative Wave -->
            <div class="absolute bottom-0 right-0 z-0 opacity-10">
                <svg width="300" height="300" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#FBBF24" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.6,-46.6C91.4,-34.1,98.2,-19.2,95.8,-4.9C93.4,9.5,81.8,23.3,70.8,35.4C59.8,47.5,49.5,57.9,37.6,65.9C25.7,73.9,12.2,79.5,-2.2,83.3C-16.6,87.1,-31.9,89.1,-45.6,83.3C-59.2,77.5,-71.2,63.9,-79.9,48.8C-88.6,33.7,-93.9,17.1,-93.3,0.9C-92.7,-15.3,-86.2,-31.1,-75.8,-43.8C-65.4,-56.5,-51.1,-66.1,-36.8,-73.2C-22.5,-80.3,-8.2,-84.9,4.1,-92C16.4,-99.1,30.5,-103.7,44.7,-76.4Z" transform="translate(100 100)" />
                </svg>
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
