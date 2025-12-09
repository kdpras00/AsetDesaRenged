@extends('layouts.app')

@section('title', 'Dashboard Kepala Desa - Desa Renged')

@section('sidebar')
    @include('kepala-desa.sidebar')
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="mb-8 relative rounded-xl overflow-hidden bg-blue-900">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/images/background-renged.jpeg') }}" class="w-full h-full object-cover opacity-20" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-800 to-transparent"></div>
    </div>
    <div class="relative p-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-blue-100">Panel kendali utama manajemen aset dan layanan administrasi desa.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
     <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center hover:shadow-md transition-shadow text-center">
        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 mb-3">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <div class="text-sm font-medium text-gray-500">Total Aset</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['total_assets'] }}</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center hover:shadow-md transition-shadow text-center">
          <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600 mb-3">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="text-sm font-medium text-gray-500">Nilai Aset</div>
        <div class="text-xl font-bold text-gray-900">Rp {{ number_format($stats['total_asset_value'], 0, ',', '.') }}</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center hover:shadow-md transition-shadow text-center">
         <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600 mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div class="text-sm font-medium text-gray-500">Butuh Verifikasi</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_verification'] }}</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center hover:shadow-md transition-shadow text-center">
         <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-3">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="text-sm font-medium text-gray-500">Surat Selesai</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['verified_letters'] }}</div>
    </div>
</div>



<!-- Charts & Activity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart Section -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
            Statistik Verifikasi Surat
        </h3>
        <div class="h-64 relative flex items-center justify-center">
            <canvas id="verificationChart"></canvas>
        </div>
    </div>

    <!-- Recent Letters (Moved inside grid) -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="font-bold text-gray-900 text-lg">Persetujuan Pending</h2>
            <a href="{{ route('kepala-desa.letters.index') }}" class="text-sm text-blue-600 font-medium hover:underline">Lihat Semua</a>
        </div>

    <div class="divide-y divide-gray-100">
        @forelse($recent_letters as $letter)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded mb-2">Nomor: {{ $letter->letter_number }}</span>
                        <h4 class="font-bold text-gray-900">{{ $letter->letterType->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Pemohon: <span class="font-medium text-gray-900">{{ $letter->user->name }}</span></p>
                    </div>
                    <a href="{{ route('kepala-desa.letters.index') }}" class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                        Verifikasi
                    </a>
                </div>
                 <div class="mt-2 text-sm text-gray-500">
                    <span class="mr-4">📅 Diajukan: {{ $letter->request_date->format('d/m/Y') }}</span>
                    <span>✍️ Diproses Admin: {{ $letter->process_date ? $letter->process_date->format('d/m/Y') : '-' }}</span>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-gray-400">
                <svg class="mx-auto h-12 w-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-medium">Tidak ada validasi surat yang tertunda.</p>
            </div>
        @endforelse
    </div>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('verificationChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Disetujui', 'Ditolak'],
            datasets: [{
                data: {!! json_encode($verification_chart['data']) !!},
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection
