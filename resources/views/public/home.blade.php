@extends('layouts.public')

@section('title', 'Beranda - Website Resmi Desa Renged')

@section('content')

<!-- Official Hero Slider / Banner -->
<section class="relative bg-white">
    <!-- Main Banner Image -->
    <div class="relative h-[500px] w-full overflow-hidden">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Kantor Desa Renged" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-transparent"></div>
        
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-screen-xl mx-auto px-4 w-full">
                <div class="max-w-2xl text-white">
                    <span class="inline-block py-1 px-3 rounded bg-blue-600 text-xs font-bold tracking-wider mb-4">WEBSITE RESMI</span>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Selamat Datang di <br>Pemerintah Desa Renged</h1>
                    <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                        Mewujudkan tata kelola pemerintahan desa yang transparan, akuntabel, dan mengutamakan pelayanan prima bagi seluruh masyarakat Desa Renged.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('public.layanan') }}" class="px-6 py-3 bg-white text-blue-900 font-bold rounded hover:bg-blue-50 transition-colors shadow-lg">
                            Layanan Mandiri
                        </a>
                        <a href="#" class="px-6 py-3 border-2 border-white text-white font-bold rounded hover:bg-white/10 transition-colors">
                            Profil Desa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Running Text / Pengumuman -->
<div class="bg-blue-800 text-white border-b-4 border-yellow-500 relative overflow-hidden">
    <div class="max-w-screen-xl mx-auto px-4 flex items-center h-12">
        <div class="bg-blue-900 h-full flex items-center px-4 font-bold z-10 shrink-0 shadow-lg">
            INFO TERKINI
        </div>
        <div class="flex-grow overflow-hidden relative h-full flex items-center">
            <div class="whitespace-nowrap animate-marquee px-4 text-sm font-medium">
                Selamat Datang di Website Resmi Desa Renged, Kecamatan Kresek, Kabupaten Tangerang. | Layanan Administrasi Desa Buka Senin-Jumat Pukul 08.00 - 16.00 WIB. | Mari wujudkan Desa Renged yang Maju dan Sejahtera.
            </div>
        </div>
    </div>
</div>

<!-- Sambutan Kepala Desa (Placeholder) -->
<section class="py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/3">
                <div class="relative rounded-lg overflow-hidden shadow-2xl border-4 border-gray-100">
                    <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Kepala Desa" class="w-full h-auto object-cover grayscale hover:grayscale-0 transition-all duration-500">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white text-center">
                        <h3 class="font-bold text-xl">Nama Kepala Desa</h3>
                        <p class="text-sm text-gray-300">Kepala Desa Renged</p>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/3">
                <h2 class="text-blue-600 font-bold uppercase tracking-wide text-sm mb-2">Sambutan Kepala Desa</h2>
                <h3 class="text-3xl font-bold text-gray-900 mb-6">Membangun Desa Bersama Masyarakat</h3>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh.<br><br>
                    Puji syukur ke hadirat Allah SWT, atas rahmat dan karunia-Nya kita bisa meluncurkan website resmi Desa Renged ini. Website ini hadir sebagai wujud komitmen kami dalam mewujudkan transparansi dan kemudahan akses informasi bagi seluruh warga.
                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Kami berharap website ini dapat menjadi jembatan informasi antara pemerintah desa dan masyarakat, serta mempermudah pelayanan administrasi yang lebih efisien dan modern.
                </p>
                <img src="{{ asset('storage/images/signature.png') }}" alt="Tanda Tangan Kepala Desa" class="h-20 opacity-80 mt-2">
            </div>
        </div>
    </div>
</section>

<!-- Layanan Unggulan Cards -->
<section class="py-20 bg-gray-50 border-t border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Layanan Publik</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Akses layanan administrasi desa dengan mudah, cepat, dan transparan secara online.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 group overflow-hidden">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/images/background-renged2.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Aset">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors"></div>
                </div>
                <div class="p-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Peminjaman Aset</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">Layanan peminjaman inventaris desa untuk keperluan warga dengan prosedur yang mudah.</p>
                    <a href="{{ route('warga.loans.index') }}" class="text-blue-600 font-medium text-sm hover:underline flex items-center">
                        Ajukan Peminjaman <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 group overflow-hidden">
                 <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/images/background-renged3.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Surat">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors"></div>
                </div>
                <div class="p-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Surat Menyurat</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">Pembuatan surat keterangan domisili, usaha, dan administrasi kependudukan lainnya.</p>
                    <a href="{{ route('warga.letters.index') }}" class="text-blue-600 font-medium text-sm hover:underline flex items-center">
                        Buat Surat <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 group overflow-hidden">
                 <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/images/background-renged4.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Verifikasi">
                    <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors"></div>
                </div>
                <div class="p-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Verifikasi Dokumen</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">Cek keaslian surat yang diterbitkan desa melalui scan QR Code atau kode unik.</p>
                    <a href="{{ route('verification.index') }}" class="text-blue-600 font-medium text-sm hover:underline flex items-center">
                        Verifikasi Sekarang <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('public.layanan') }}" class="inline-block px-8 py-3 bg-gray-900 text-white rounded font-medium hover:bg-gray-800 transition-colors">Lihat Semua Layanan</a>
        </div>
    </div>
</section>

<!-- Statistik Singkat (Parallax / Image BG) -->
<section class="relative py-20 bg-fixed bg-cover bg-center" style="background-image: url('{{ asset('storage/images/background-renged7.jpeg') }}');">
    <div class="absolute inset-0 bg-blue-900/80"></div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-12">Data Desa Renged</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="p-4 border border-blue-400/30 rounded backdrop-blur-sm">
                <div class="text-4xl font-bold mb-2">3.5k</div>
                <div class="text-blue-200 text-sm uppercase tracking-wide">Penduduk</div>
            </div>
            <div class="p-4 border border-blue-400/30 rounded backdrop-blur-sm">
                <div class="text-4xl font-bold mb-2">1.2k</div>
                <div class="text-blue-200 text-sm uppercase tracking-wide">Kepala Keluarga</div>
            </div>
            <div class="p-4 border border-blue-400/30 rounded backdrop-blur-sm">
                <div class="text-4xl font-bold mb-2">450</div>
                <div class="text-blue-200 text-sm uppercase tracking-wide">Aset Desa</div>
            </div>
            <div class="p-4 border border-blue-400/30 rounded backdrop-blur-sm">
                <div class="text-4xl font-bold mb-2">98%</div>
                <div class="text-blue-200 text-sm uppercase tracking-wide">Kepuasan</div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes marquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
.animate-marquee {
    display: inline-block;
    animation: marquee 20s linear infinite;
}
</style>
@endsection
