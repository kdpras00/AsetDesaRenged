@extends('layouts.public')

@section('title', 'Beranda - Website Resmi Desa Renged')

@section('content')

<!-- Running Text / Pengumuman (Restored) -->
<div class="bg-blue-800 text-white border-b-2 border-yellow-400 relative overflow-hidden z-20">
    <div class="container mx-auto px-4 flex items-center h-10">
        <div class="bg-blue-900 h-full flex items-center px-4 font-bold text-xs md:text-sm z-10 shrink-0 shadow-lg relative after:absolute after:right-[-10px] after:top-0 after:border-t-[40px] after:border-t-blue-900 after:border-r-[10px] after:border-r-transparent">
            <span class="text-yellow-400 mr-2">📢</span> INFO TERKINI
        </div>
        <div class="flex-grow overflow-hidden relative h-full flex items-center">
            <div class="whitespace-nowrap animate-marquee px-4 text-xs md:text-sm font-medium">
                Selamat Datang di Website Resmi Desa Renged, Kecamatan Kresek, Kabupaten Tangerang. | Layanan Administrasi Desa Buka Senin-Jumat Pukul 08.00 - 16.00 WIB. | Mari wujudkan Desa Renged yang Maju dan Sejahtera. | Segera lakukan perekaman e-KTP bagi yang belum memiliki.
            </div>
        </div>
    </div>
</div>

<!-- Hero Section: Clean, Spacious, and "Safe" Layout -->
<!-- Changed min-h to ensure it covers screens but flex-layout dictates height -->
<div class="relative bg-blue-900 flex flex-col justify-between overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" alt="Desa Renged" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/95 via-blue-900/80 to-blue-800/60 mix-blend-multiply"></div>
    </div>

    <!-- Content Container -->
    <!-- Added pt-32 and pb-32 (reduced from 48) to lift the curve -->
    <div class="relative z-10 container mx-auto px-4 pt-32 pb-32">
        <div class="max-w-3xl">
            <!-- Badge -->
            <div class="inline-flex items-center bg-yellow-500/10 border border-yellow-500/30 rounded-xl px-4 py-2 mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></span>
                <div class="flex flex-col text-left">
                    <span class="text-yellow-100 text-sm font-semibold tracking-wide uppercase">Website Resmi Pemerintah</span>
                    <span class="text-yellow-200 text-xs font-medium tracking-wide uppercase mt-0.5">Pembuatan Surat Digital dan Peminjaman Asset</span>
                </div>
            </div>
            
            <!-- Headline -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-8 leading-tight drop-shadow-lg">
                Selamat Datang di <br>
                <span class="text-yellow-400">Desa Renged</span>
            </h1>
            
            <!-- Description -->
            <p class="text-xl text-blue-100 mb-10 leading-relaxed max-w-2xl font-light">
                Pusat pelayanan dan informasi digital untuk mewujudkan tata kelola desa yang transparan, akuntabel, dan melayani.
            </p>

            <!-- Buttons: Clear, Solid, No Overlap Risk -->
            <div class="flex flex-wrap gap-5">
                <a href="{{ route('public.layanan') }}" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                    Layanan Mandiri
                </a>
                <a href="#profil" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-900 transition-colors">
                    Profil Desa
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Wave: Positioned absolutely at bottom but padding above protects content -->
    <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none">
        <svg class="fill-gray-50 w-full h-auto" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,0 C240,120 480,120 720,60 C960,0 1200,0 1440,60 L1440,120 L0,120 Z"></path>
        </svg>
    </div>
</div>

<!-- Quick Access Section: Standard Block (No Negative Margins) -->
<section class="bg-gray-50 py-16 relative z-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 -mt-12 md:-mt-16 relative z-30">
            @foreach([
                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Cek Surat', 'desc' => 'Validasi Dokumen', 'color' => 'bg-emerald-600', 'link' => route('verification.index')],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Data Desa', 'desc' => 'Statistik Penduduk', 'color' => 'bg-blue-600', 'link' => route('public.stats')],
                ['icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'title' => 'Peminjaman', 'desc' => 'Aset Inventaris', 'color' => 'bg-purple-600', 'link' => route('warga.loans.index')],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Peta Desa', 'desc' => 'Wilayah Digital', 'color' => 'bg-orange-600', 'link' => route('profile.peta')]
            ] as $card)
            <!-- Simple, Clean Cards -->
            <a href="{{ $card['link'] }}" class="bg-white rounded-xl p-6 shadow-xl border border-gray-200 border-b-4 hover:border-b-blue-600 hover:-translate-y-2 transition-all duration-300 flex flex-col items-start group relative overflow-hidden">
                <div class="{{ $card['color'] }} p-3 rounded-lg text-white mb-4 group-hover:shadow-lg transition-shadow">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ $card['title'] }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ $card['desc'] }}</p>
                <div class="mt-4 text-blue-600 text-sm font-semibold flex items-center group-hover:translate-x-1 transition-transform">
                    Akses <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Sambutan Kades (Simple & Human) -->
<section id="profil" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <!-- Image -->
            <div class="w-full md:w-1/3">
                <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-auto object-cover filter brightness-90">
                </div>
            </div>
            
            <!-- Text -->
            <div class="w-full md:w-2/3">
                <h4 class="text-blue-600 font-bold uppercase text-sm tracking-wide mb-2">Sambutan Kepala Desa</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Bersama Membangun Desa Renged</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        Assalamu'alaikum Warahmatullahi Wabarakatuh.
                    </p>
                    <p>
                        Selamat datang di website resmi Desa Renged. Website ini kami buat untuk memudahkan warga dalam mengakses informasi dan layanan desa. Kami ingin pemerintahan desa berjalan lebih transparan dan bisa melayani bapak/ibu sekalian dengan lebih cepat.
                    </p>
                    <p>
                        Silakan manfaatkan layanan surat online dan update informasi kegiatan desa melalui website ini.
                    </p>
                </div>
                <div class="mt-8">
                    <div class="text-lg font-bold text-gray-900">Bapak Wawan</div>
                    <div class="text-gray-500">Kepala Desa Renged</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terkini (Standard Grid) -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Berita & Informasi Desa</h2>
            <p class="text-gray-500 mt-2">Update kegiatan terbaru pemerintahan Desa Renged</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- News Cards (Standard) -->
             <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <img src="{{ asset('storage/images/background-renged2.jpeg') }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-xs text-gray-400 mb-2">18 Desember 2024</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600"><a href="#">Penyaluran BLT Tahap 4</a></h3>
                    <p class="text-gray-600 text-sm line-clamp-3">Penyaluran bantuan berjalan lancar dan tertib di Balai Desa...</p>
                </div>
            </article>

            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <img src="{{ asset('storage/images/background-renged3.jpeg') }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-xs text-gray-400 mb-2">15 Desember 2024</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600"><a href="#">Posyandu Balita Sejahtera</a></h3>
                    <p class="text-gray-600 text-sm line-clamp-3">Layanan kesehatan gratis untuk balita dan ibu hamil di setiap dusun...</p>
                </div>
            </article>

            <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <img src="{{ asset('storage/images/background-renged4.jpeg') }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="text-xs text-gray-400 mb-2">10 Desember 2024</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600"><a href="#">Kerjabakti Lingkungan</a></h3>
                    <p class="text-gray-600 text-sm line-clamp-3">Warga bergotong royong membersihkan saluran air antisipasi banjir...</p>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Footer Pre-Section -->
<section class="bg-blue-900 py-16 text-center text-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6">Butuh Bantuan Operator?</h2>
        <p class="text-blue-200 mb-8 max-w-xl mx-auto">Jika mengalami kendala teknis atau pertanyaan seputar layanan, tim kami siap membantu Anda.</p>
         <a href="https://wa.me/6283876961269" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 rounded-lg font-bold transition-colors">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.997.585 1.957.893 3.068.893 3.179 0 5.767-2.587 5.767-5.766.001-3.187-2.575-5.77-5.769-5.77zm0 13.891c-2.31 0-4.223-1.077-5.462-2.83l-4.52 1.185 1.206-4.399c-1.397-2.083-1.066-5.067.876-6.91 1.996-1.896 5.148-1.896 7.144 0 1.995 1.895 1.995 4.966 0 6.86-1.996 1.895-5.148 1.895-7.144 0"/></svg>
            Hubungi via WhatsApp
        </a>
    </div>
</section>

<!-- Custom Animations CSS -->
<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
    
    .animate-fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .animate-fade-in-down { animation: fadeInDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .animate-marquee { display: inline-block; animation: marquee 25s linear infinite; }
    .animate-marquee:hover { animation-play-state: paused; cursor: pointer; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
</style>

@endsection
