@extends('layouts.public')

@section('title', 'Layanan - Sistem Manajemen Aset Desa Renged')

@section('content')
<!-- Header -->
<div class="relative bg-gray-900 py-24 sm:py-32">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('storage/images/background-renged6.jpeg') }}" alt="Office Work" class="h-full w-full object-cover object-center opacity-20">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Layanan Digital Desa</h1>
        <p class="mt-6 text-lg leading-8 text-gray-300">
            Daftar lengkap layanan yang dapat diakses oleh warga Desa Renged secara online.
        </p>
    </div>
</div>

<!-- Services List -->
<div class="py-24 sm:py-32 bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        
        <!-- Peminjaman Aset -->
        <div class="mx-auto max-w-2xl lg:max-w-none flex flex-col lg:flex-row gap-16 items-center mb-32">
            <div class="lg:w-1/2 aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ asset('storage/images/background-renged2.jpeg') }}" alt="Equipment" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            </div>
            <div class="lg:w-1/2">
                <div class="flex items-center gap-x-4 text-xs">
                    <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Inventaris</span>
                </div>
                <h3 class="mt-3 text-3xl font-bold leading-tight text-gray-900 dark:text-white">Peminjaman Aset Desa</h3>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Warga dapat meminjam berbagai aset desa yang tersedia untuk keperluan kegiatan sosial, keagamaan, maupun pribadi. Aset yang tersedia meliputi tenda, kursi lipat, sound system, proyektor, dan peralatan kebersihan.
                </p>
                <ul class="mt-8 space-y-4 text-gray-600 dark:text-gray-400">
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-blue-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Cek ketersediaan aset secara real-time
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-blue-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Pengajuan via website tanpa perlu ke kantor
                    </li>
                    <li class="flex gap-x-3">
                        <svg class="h-6 w-5 flex-none text-blue-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Persetujuan cepat oleh operator desa
                    </li>
                </ul>
                <div class="mt-10">
                    <a href="#" class="text-sm font-semibold leading-6 text-blue-600 hover:text-blue-500">Lihat Daftar Aset <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>

        <!-- Surat -->
        <div class="mx-auto max-w-2xl lg:max-w-none flex flex-col lg:flex-row-reverse gap-16 items-center">
            <div class="lg:w-1/2 aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ asset('storage/images/background-renged3.jpeg') }}" alt="Writing" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            </div>
            <div class="lg:w-1/2">
                <div class="flex items-center gap-x-4 text-xs">
                    <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Administrasi</span>
                </div>
                <h3 class="mt-3 text-3xl font-bold leading-tight text-gray-900 dark:text-white">Pelayanan Surat Menyurat</h3>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Permudah urusan administrasi Anda dengan layanan surat digital. Dokumen dapat dicetak mandiri setelah diverifikasi dan ditandatangani secara elektronik oleh Kepala Desa.
                </p>
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        <div class="font-semibold text-gray-900 dark:text-white">Surat Keterangan Usaha</div>
                        <div class="text-sm text-gray-500">Untuk keperluan perbankan/izin</div>
                    </div>
                    <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        <div class="font-semibold text-gray-900 dark:text-white">Surat Domisili</div>
                        <div class="text-sm text-gray-500">Keterangan tempat tinggal</div>
                    </div>
                    <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        <div class="font-semibold text-gray-900 dark:text-white">Surat Keterangan Tidak Mampu</div>
                        <div class="text-sm text-gray-500">Untuk bantuan sosial/pendidikan</div>
                    </div>
                    <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
                        <div class="font-semibold text-gray-900 dark:text-white">Surat Pengantar SKCK</div>
                        <div class="text-sm text-gray-500">Persyaratan kepolisian</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
