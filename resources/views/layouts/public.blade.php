<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Aset Desa Renged')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white dark:bg-gray-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-200 glass-nav dark:bg-gray-900/90 dark:border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-10 mr-3" alt="Logo Desa Renged">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">Desa Renged</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @auth
                    <a href="{{ url('/home') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-6 py-2.5 text-center shadow-lg hover:shadow-xl transition-all duration-300">
                        Dashboard
                    </a>
                @else
                    <div class="flex space-x-2">
                        <a href="{{ route('login') }}" class="text-gray-900 hover:text-blue-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-full text-sm px-6 py-2.5 text-center transition-all duration-300">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-6 py-2.5 text-center shadow-blue-500/30 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            Daftar
                        </a>
                    </div>
                @endauth
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
                    <li>
                        <a href="{{ route('home') }}" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 transition-colors {{ Request::routeIs('home') ? 'text-blue-700 md:text-blue-700 dark:text-blue-500' : 'text-gray-900 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}" aria-current="page">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('public.layanan') }}" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 transition-colors {{ Request::routeIs('public.layanan') ? 'text-blue-700 md:text-blue-700 dark:text-blue-500' : 'text-gray-900 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">Layanan</a>
                    </li>
                    <li>
                        <a href="{{ route('public.stats') }}" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 transition-colors {{ Request::routeIs('public.stats') ? 'text-blue-700 md:text-blue-700 dark:text-blue-500' : 'text-gray-900 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">Statistik</a>
                    </li>
                    <li>
                        <a href="{{ route('verification.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 transition-colors {{ Request::routeIs('verification.index') ? 'text-blue-700 md:text-blue-700 dark:text-blue-500' : 'text-gray-900 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">Verifikasi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="pt-[72px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-8 mr-3" alt="Logo Desa Renged">
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Desa Renged</span>
                    </a>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 max-w-sm">
                        Sistem Informasi Manajemen Aset dan Pelayanan Desa Terpadu. Mewujudkan tata kelola desa yang transparan, akuntabel, dan modern.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Layanan</h2>
                        <ul class="text-gray-500 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Peminjaman Aset</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Surat Keterangan</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">Verifikasi Dokumen</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Informasi</h2>
                        <ul class="text-gray-500 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Tentang Kami</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Struktur Desa</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">Berita Desa</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Hubungi Kami</h2>
                        <ul class="text-gray-500 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> (021) 555-0123</span>
                            </li>
                            <li>
                                <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> kantor@renged.id</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="{{ route('home') }}" class="hover:underline">Pemerintah Desa Renged</a>. All Rights Reserved.
                </span>
                <div class="flex mt-4 sm:justify-center sm:mt-0 space-x-5">
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                              <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Facebook page</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                            <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 15.184 11.732 11.732 0 0 0 6.291 17c7.548 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Twitter page</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
