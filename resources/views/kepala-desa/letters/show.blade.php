@extends('layouts.app')

@section('title', 'Detail Verifikasi Surat - Desa Renged')

@section('sidebar')
    @include('kepala-desa.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('kepala-desa.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('kepala-desa.letters.index') }}" class="hover:text-blue-600">Verifikasi Surat</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Detail & Persetujuan</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Pemohon -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Data Pemohon</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium text-gray-900">{{ $letter->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-medium text-gray-900 font-mono">{{ $letter->user->nik }}</p>
                        </div>
                        <div class="col-span-2">
                             <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-900">{{ $letter->user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Surat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Detail Surat</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Jenis Surat</p>
                            <p class="font-bold text-blue-600 text-lg">{{ $letter->letterType->name }}</p>
                        </div>
                        <div class="text-right">
                             <p class="text-sm text-gray-500">Nomor Surat</p>
                            <p class="font-mono font-bold text-gray-900">{{ $letter->letter_number }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Keperluan</p>
                        <div class="bg-gray-50 p-4 rounded-lg mt-1 text-gray-700 italic">
                            "{{ $letter->purpose }}"
                        </div>
                    </div>

                    <!-- Custom Data Fields -->
                    @if($letter->data)
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <p class="text-sm font-semibold text-gray-900 mb-3">Data Khusus Surat</p>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($letter->data as $key => $value)
                            <div>
                                <p class="text-xs text-uppercase text-gray-500 mb-1">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                <p class="text-sm font-medium text-gray-900">{{ is_array($value) ? json_encode($value) : $value }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                     @if($letter->attachment_path)
                    <div class="mt-4 border-t border-gray-100 pt-4">
                         <p class="text-sm text-gray-500 mb-2">Lampiran Dokumen</p>
                         <a href="{{ Storage::url($letter->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Lihat Lampiran
                         </a>
                    </div>
                    @endif
                </div>
            </div>
            
             <!-- Operator Information -->
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                         <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 font-bold">
                            {{ substr($letter->operator->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Diproses oleh: {{ $letter->operator->name ?? 'Admin' }}</h4>
                        <p class="text-xs text-gray-500 mb-2">{{ \Carbon\Carbon::parse($letter->process_date)->translatedFormat('d F Y, H:i') }}</p>
                        @if($letter->operator_notes)
                        <div class="bg-white p-3 rounded-lg border border-blue-100 text-sm italic text-gray-700">
                            "{{ $letter->operator_notes }}"
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                 <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Tindakan</h3>
                 
                 @if($letter->status == 'processed')
                 <div class="space-y-3">
                     <p class="text-sm text-gray-600 mb-4">
                         Pastikan data sudah benar sebelum menyetujui. Surat yang disetujui akan diterbitkan dengan Tanda Tangan Elektronik (QR Code).
                     </p>

                     <form id="verifyForm" action="{{ route('kepala-desa.letters.verify', $letter) }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmVerify()" class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition flex justify-center items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Setujui & Tanda Tangani
                        </button>
                     </form>
                     
                     <hr class="border-gray-100 my-4">

                     <button onclick="document.getElementById('rejectSection').classList.toggle('hidden')" class="w-full py-2.5 px-4 border border-red-300 rounded-lg shadow-sm text-sm font-bold text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        Tolak / Revisi
                     </button>
                     
                     <div id="rejectSection" class="hidden mt-3 bg-red-50 p-4 rounded-lg border border-red-100">
                         <form id="rejectForm" action="{{ route('kepala-desa.letters.reject', $letter) }}" method="POST" onsubmit="confirmReject(event)">
                            @csrf
                            <label class="block text-xs font-semibold text-red-700 mb-1">Alasan Penolakan</label>
                            <textarea name="reason" rows="3" required class="w-full text-sm border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 mb-2" placeholder="Wajib diisi..."></textarea>
                            <button type="submit" class="w-full py-2 px-4 rounded-lg text-xs font-bold text-white bg-red-600 hover:bg-red-700">
                                Konfirmasi Tolak
                            </button>
                         </form>
                     </div>
                 </div>
                 @elseif($letter->status == 'verified')
                    <div class="flex flex-col items-center justify-center text-center p-4 bg-green-50 rounded-lg border border-green-100">
                         <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-green-800">Sudah Disetujui</span>
                        <p class="text-xs text-green-600 mt-1">Pada: {{ \Carbon\Carbon::parse($letter->approved_date)->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                 @else
                    <div class="flex flex-col items-center justify-center text-center p-4 bg-red-50 rounded-lg border border-red-100">
                         <svg class="w-12 h-12 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="font-bold text-red-800">Ditolak</span>
                         <p class="text-xs text-red-600 mt-1 italic">"{{ $letter->rejection_reason }}"</p>
                    </div>
                 @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmVerify() {
        Swal.fire({
            title: 'Setujui & Tanda Tangani?',
            text: "Surat akan diverifikasi dan QR Code akan digenerate sebagai tanda tangan elektronik sah.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.showLoading();
                document.getElementById('verifyForm').submit();
            }
        });
    }

    function confirmReject(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Tolak Permohonan?',
            text: "Apakah Anda yakin ingin menolak atau meminta revisi permohonan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.showLoading();
                document.getElementById('rejectForm').submit();
            }
        });
    }
</script>
@endpush
