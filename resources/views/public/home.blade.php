@extends('layouts.public')

@section('title', 'Beranda - Sistem Manajemen Aset Desa Renged')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Desa Renged Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
    </div>
    <div class="relative max-w-screen-xl px-4 py-32 mx-auto lg:flex lg:h-screen lg:items-center">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl font-extrabold tracking-tight leading-none md:text-5xl lg:text-6xl text-white mb-6">
                Transparansi & Efisiensi <br>
                <span class="text-blue-400">Aset Desa Renged</span>
            </h1>
            <p class="mt-4 max-w-xl mx-auto sm:text-xl/relaxed text-gray-300 mb-8">
                Sistem terintegrasi untuk pengelolaan aset, peminjaman barang, dan pelayanan surat menyurat digital bagi warga Desa Renged, Kecamatan Kresek.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('login') }}" class="block w-full rounded bg-blue-600 px-12 py-3 text-sm font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring active:bg-blue-500 sm:w-auto transition-transform hover:-translate-y-1">
                    Mulai Sekarang
                </a>
                <a href="{{ route('public.layanan') }}" class="block w-full rounded bg-white/10 backdrop-blur px-12 py-3 text-sm font-medium text-white shadow hover:bg-white/20 focus:outline-none focus:ring active:bg-white/30 sm:w-auto transition-transform hover:-translate-y-1">
                    Pelajari Layanan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Layanan Unggulan</h2>
            <p class="mt-4 text-gray-500 dark:text-gray-400">
                Memudahkan warga desa dalam mengakses layanan publik secara digital.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Asset Loan -->
            <div class="block rounded-xl border border-gray-100 bg-white p-8 shadow-xl transition hover:border-blue-500/10 hover:shadow-blue-500/10 dark:border-gray-800 dark:bg-gray-900 dark:shadow-gray-800">
                <div class="h-48 w-full overflow-hidden rounded-lg mb-6">
                    <img src="{{ asset('storage/images/background-renged2.jpeg') }}" alt="Assets" class="h-full w-full object-cover transition duration-500 hover:scale-110">
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Peminjaman Aset</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pinjam inventaris desa seperti tenda, kursi, dan peralatan lainnya untuk keperluan acara warga dengan proses yang mudah dan transparan.
                </p>
            </div>

            <!-- Letters -->
            <div class="block rounded-xl border border-gray-100 bg-white p-8 shadow-xl transition hover:border-blue-500/10 hover:shadow-blue-500/10 dark:border-gray-800 dark:bg-gray-900 dark:shadow-gray-800">
                <div class="h-48 w-full overflow-hidden rounded-lg mb-6">
                    <img src="{{ asset('storage/images/background-renged3.jpeg') }}" alt="Documents" class="h-full w-full object-cover transition duration-500 hover:scale-110">
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Surat Digital</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pengajuan surat keterangan domisili, usaha, dan dokumen lainnya secara online. Pantau status pengajuan real-time.
                </p>
            </div>

            <!-- Verification -->
            <div class="block rounded-xl border border-gray-100 bg-white p-8 shadow-xl transition hover:border-blue-500/10 hover:shadow-blue-500/10 dark:border-gray-800 dark:bg-gray-900 dark:shadow-gray-800">
                <div class="h-48 w-full overflow-hidden rounded-lg mb-6">
                    <img src="{{ asset('storage/images/background-renged4.jpeg') }}" alt="Security" class="h-full w-full object-cover transition duration-500 hover:scale-110">
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Verifikasi QR Code</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Sistem validasi dokumen menggunakan QR Code untuk menjamin keaslian surat yang diterbitkan oleh pemerintah desa.
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('public.layanan') }}" class="inline-flex items-center rounded bg-blue-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:bg-blue-500">
                Lihat Semua Layanan
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-blue-600 dark:bg-blue-900">
    <div class="max-w-screen-xl px-4 py-16 mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-16 items-center">
            <div class="relative h-64 overflow-hidden rounded-lg sm:h-80 lg:order-last lg:h-full">
                <img alt="Community" src="{{ asset('storage/images/background-renged5.jpeg') }}" class="absolute inset-0 h-full w-full object-cover" />
            </div>

            <div class="lg:py-24">
                <h2 class="text-3xl font-bold sm:text-4xl text-white">Bergabunglah dengan Desa Digital</h2>
                <p class="mt-4 text-blue-100">
                    Daftarkan diri Anda sekarang untuk mengakses seluruh layanan digital Desa Renged. Nikmati kemudahan administrasi dari rumah.
                </p>
                <a href="{{ route('register') }}" class="mt-8 inline-block rounded border border-white bg-white px-12 py-3 text-sm font-medium text-blue-600 hover:bg-transparent hover:text-white focus:outline-none focus:ring active:text-white transition">
                    Daftar Akun Warga
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
