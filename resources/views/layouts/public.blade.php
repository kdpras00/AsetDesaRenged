<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Aset Desa Renged')</title>
    <meta name="description" content="Website Resmi Pemerintah Desa Renged, Kecamatan Kresek, Kabupaten Tangerang.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Top Bar (Official Info) -->
    <div class="bg-blue-900 text-white py-2 text-sm hidden md:block border-b border-blue-800">
        <div class="max-w-screen-xl mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>(021) 555-0123</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>kantor@renged.desa.id</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Senin - Jumat, 08:00 - 16:00</span>
                </div>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-blue-300 transition-colors">Facebook</a>
                <a href="https://www.instagram.com/desa_renged2020/" class="hover:text-blue-300 transition-colors" target="_blank">Instagram</a>
                <a href="#" class="hover:text-blue-300 transition-colors">Youtube</a>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-12 w-auto" alt="Logo Desa Renged">
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-gray-900 leading-tight group-hover:text-blue-700 transition-colors">DESA RENGED</span>
                            <span class="text-xs font-medium text-gray-500 tracking-wider">KABUPATEN TANGERANG</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ Request::routeIs('home') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">
                        Beranda
                    </a>
                    <div class="relative group">
                         <button class="px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-gray-50 inline-flex items-center transition-colors">
                            Profil Desa
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <!-- Dropdown (Simple Hover) -->
                         <div class="absolute left-0 mt-0 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                            <a href="{{ route('profile.sejarah') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-700">Sejarah Desa</a>
                            <a href="{{ route('profile.visi-misi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-700">Visi & Misi</a>
                            <a href="{{ route('profile.struktur') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-700">Struktur Organisasi</a>
                            <a href="{{ route('profile.peta') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-700">Peta Desa</a>
                        </div>
                    </div>
                    <a href="{{ route('public.layanan') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ Request::routeIs('public.layanan') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">
                        Layanan
                    </a>
                    <a href="{{ route('public.stats') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ Request::routeIs('public.stats') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">
                        Statistik
                    </a>
                     <a href="{{ route('verification.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ Request::routeIs('verification.index') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">
                        Verifikasi Surat
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3 ml-6 border-l pl-6 border-gray-200">
                    @auth
                        <a href="{{ url('/home') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-700 font-medium text-sm transition-colors">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center">
                    <button data-collapse-toggle="mobile-menu" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-gray-50">Beranda</a>
                <a href="{{ route('public.layanan') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-gray-50">Layanan</a>
                <a href="{{ route('public.stats') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-gray-50">Statistik</a>
                <a href="{{ route('verification.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-gray-50">Verifikasi Surat</a>
                @auth
                    <a href="{{ url('/home') }}" class="block w-full text-center mt-4 px-4 py-3 rounded-md text-base font-medium bg-blue-600 text-white hover:bg-blue-700">Dashboard</a>
                @else
                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <a href="{{ route('login') }}" class="block text-center px-4 py-3 rounded-md text-base font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Masuk</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Official Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8 border-t-4 border-blue-600">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Profile -->
                <div>
                     <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-10 w-auto bg-white rounded-full p-1" alt="Logo">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-white uppercase leading-none">Desa Renged</span>
                            <span class="text-xs text-blue-400">Kabupaten Tangerang</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed mb-6">
                        Website resmi Desa Renged, media komunikasi dan transparansi pemerintah desa untuk mewujudkan pelayanan publik yang modern, akuntabel, dan terpercaya.
                    </p>
                    <div class="flex space-x-4">
                        <!-- Social Icons -->
                         <a href="#" class="text-gray-400 hover:text-white transition-colors bg-gray-800 p-2 rounded-full">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                        </a>
                        <a href="https://www.instagram.com/desa_renged2020/" class="text-gray-400 hover:text-white transition-colors bg-gray-800 p-2 rounded-full" target="_blank">
                             <span class="sr-only">Instagram</span>
                             <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.37c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-white text-lg font-bold mb-6 relative pl-4 border-l-4 border-blue-500">Hubungi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                             <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                             <span>Jl. Raya Kresek No. 45, Desa Renged, Kec. Kresek, Kab. Tangerang, Banten 15620</span>
                        </li>
                        <li class="flex items-center">
                             <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                             <span>(021) 555-0123</span>
                        </li>
                        <li class="flex items-center">
                             <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                             <span>kantor@renged.desa.id</span>
                        </li>
                    </ul>
                </div>

                <!-- Tautan -->
                <div>
                     <h3 class="text-white text-lg font-bold mb-6 relative pl-4 border-l-4 border-blue-500">Tautan Cepat</h3>
                     <ul class="space-y-2">
                         <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Profil Desa</a></li>
                         <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Layanan Mandiri</a></li>
                         <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Transparansi Anggaran</a></li>
                         <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Pengaduan Masyarakat</a></li>
                         <li><a href="{{ route('profile.peta') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block">Peta Desa</a></li>
                     </ul>
                </div>

                <!-- Jam Layanan -->
                <div>
                    <h3 class="text-white text-lg font-bold mb-6 relative pl-4 border-l-4 border-blue-500">Jam Layanan</h3>
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between">
                                <span>Senin - Kamis</span>
                                <span class="text-white font-medium">08:00 - 16:00</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Jumat</span>
                                <span class="text-white font-medium">08:00 - 15:30</span>
                            </li>
                            <li class="flex justify-between text-gray-500">
                                <span>Sabtu - Minggu</span>
                                <span>Tutup</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center sm:text-left sm:flex justify-between items-center text-sm text-gray-500">
                <p>&copy; 2025 Pemerintah Desa Renged. All Rights Reserved.</p>
                <div class="mt-4 sm:mt-0 flex flex-wrap gap-4 justify-center sm:justify-end">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Peta Situs</a>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
