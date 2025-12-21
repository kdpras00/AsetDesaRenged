<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen Aset Desa Renged')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    
    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('home') }}" class="flex ms-2 md:me-24">
                        <img src="{{ asset('storage/images/logo-renged.png') }}" class="h-8 me-3" alt="Logo Desa Renged" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Desa Renged</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <!-- Notification Bell -->
                    @include('components.notification-bell')

                    <div class="flex items-center ms-3 relative">
                        <div>
                            <button type="button" onclick="const d = document.getElementById('dropdown-user'); d.classList.toggle('hidden');" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                        </div>
                        <div class="z-50 hidden absolute right-0 top-8 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        Pengaturan Profil
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            @yield('sidebar')
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64 relative">
        <div class="p-4 mt-14 max-w-full overflow-x-hidden">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
    


    <!-- Global Loading Overlay -->
    <div id="global-loading-overlay" class="fixed inset-0 z-[100] bg-gray-50 dark:bg-gray-900 hidden flex-col items-center justify-center transition-opacity duration-300">
        <div class="relative flex flex-col items-center animate-pulse">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-full shadow-lg mb-4">
                <img src="{{ asset('storage/images/logo-renged.png') }}" alt="Loading..." class="w-16 h-16 object-contain">
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-widest uppercase">Memproses...</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mohon tunggu sebentar</p>
        </div>
    </div>

    <script>
        // Global Loader Functions
        window.showLoading = function() {
            var loader = document.getElementById('global-loading-overlay');
            if(loader) {
                loader.classList.remove('hidden');
                loader.classList.add('flex');
            }
        };

        window.hideLoading = function() {
            var loader = document.getElementById('global-loading-overlay');
            if(loader) {
                loader.classList.add('hidden');
                loader.classList.remove('flex');
            }
        };

        // Handle Page Navigation Loading
        document.addEventListener('DOMContentLoaded', function() {
            // Attach to all links
            var links = document.querySelectorAll('a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var href = this.getAttribute('href');
                    var target = this.getAttribute('target');
                    
                    if (href && 
                        href !== '#' && 
                        href.indexOf('javascript:') !== 0 && 
                        href.indexOf('tel:') !== 0 && 
                        href.indexOf('mailto:') !== 0 && 
                        target !== '_blank' && 
                        !this.hasAttribute('download') &&
                        !this.classList.contains('no-loader')) {
                        
                        window.showLoading();
                    }
                });
            });

            // Attach to forms
            var forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
                   if(!this.classList.contains('no-loader')) {
                       window.showLoading();
                   }
                });
            });

            // Mobile Sidebar Toggle
            var toggleBtn = document.querySelector('[data-drawer-toggle="logo-sidebar"]');
            var sidebar = document.getElementById('logo-sidebar');
            
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
        
        // Hide loader when page is fully loaded
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.hideLoading();
            }
        });
    </script>

    @stack('scripts')
    
    <script>
        // Handle Session Flash Messages (using Swal from app.js)
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                window.hideLoading(); // Ensure loader is hidden
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                window.hideLoading(); // Ensure loader is hidden
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                });
            @endif

            @if(session('warning'))
                window.hideLoading(); // Ensure loader is hidden
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: "{{ session('warning') }}",
                });
            @endif
        });


        // Global Delete Confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

    </script>

</body>
</html>
