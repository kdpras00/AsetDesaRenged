@extends('layouts.app')

@section('title', 'Detail Surat - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('operator.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('operator.letters.index') }}" class="hover:text-blue-600">Layanan Surat</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Detail Permohonan</span>
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
                        <div>
                             <p class="text-sm text-gray-500">No. KK</p>
                            <p class="font-medium text-gray-900 font-mono">{{ $letter->user->kk ?? '-' }}</p>
                        </div>
                        <div>
                             <p class="text-sm text-gray-500">Nomor Telepon</p>
                            <p class="font-medium text-gray-900 font-mono">{{ $letter->user->phone ?? '-' }}</p>
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
                    <h3 class="text-lg font-bold text-gray-900">Detail Permohonan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Jenis Surat</p>
                        <p class="font-bold text-blue-600 text-lg">{{ $letter->letterType->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($letter->request_date)->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Keperluan</p>
                        <div class="bg-gray-50 p-4 rounded-lg mt-1 text-gray-700">
                            {{ $letter->purpose }}
                        </div>
                    </div>

                    <!-- Custom Data Fields based on Letter Type -->
                    @if($letter->data)
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <p class="text-sm font-semibold text-gray-900 mb-3">Data Khusus Surat</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($letter->data as $key => $value)
                                @if(!in_array($key, ['ktp_file_path', 'kk_file_path']))
                                <div>
                                    <p class="text-xs text-uppercase text-gray-500 mb-1">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                    <p class="text-sm font-medium text-gray-900">{{ is_array($value) ? json_encode($value) : $value }}</p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Dokumen Persyaratan Wajib (KTP & KK) -->
                    @if(isset($letter->data['ktp_file_path']) || isset($letter->data['kk_file_path']))
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <p class="text-sm font-semibold text-gray-900 mb-3">Dokumen Persyaratan</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if(isset($letter->data['ktp_file_path']))
                            <div class="border rounded-lg p-3 bg-gray-50">
                                <p class="text-xs font-bold text-gray-500 mb-2 uppercase">KTP Pemohon</p>
                                @php $ktpExt = pathinfo($letter->data['ktp_file_path'], PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($ktpExt), ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($letter->data['ktp_file_path']) }}" alt="KTP" class="w-full h-48 object-cover rounded-lg mb-2 hover:opacity-90 transition cursor-pointer" onclick="window.open(this.src, '_blank')">
                                @else
                                    <div class="flex items-center justify-center h-32 bg-gray-200 rounded-lg mb-2 text-gray-500">
                                        <span class="text-xs">Preview tidak tersedia (PDF)</span>
                                    </div>
                                @endif
                                <a href="{{ Storage::url($letter->data['ktp_file_path']) }}" target="_blank" class="block text-center text-xs text-blue-600 hover:text-blue-800 font-bold border border-blue-200 rounded py-1 bg-white hover:bg-blue-50">Preview KTP</a>
                            </div>
                            @endif

                            @if(isset($letter->data['kk_file_path']))
                            <div class="border rounded-lg p-3 bg-gray-50">
                                <p class="text-xs font-bold text-gray-500 mb-2 uppercase">Kartu Keluarga (KK)</p>
                                @php $kkExt = pathinfo($letter->data['kk_file_path'], PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($kkExt), ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($letter->data['kk_file_path']) }}" alt="KK" class="w-full h-48 object-cover rounded-lg mb-2 hover:opacity-90 transition cursor-pointer" onclick="window.open(this.src, '_blank')">
                                @else
                                    <div class="flex items-center justify-center h-32 bg-gray-200 rounded-lg mb-2 text-gray-500">
                                        <span class="text-xs">Preview tidak tersedia (PDF)</span>
                                    </div>
                                @endif
                                <a href="{{ Storage::url($letter->data['kk_file_path']) }}" target="_blank" class="block text-center text-xs text-blue-600 hover:text-blue-800 font-bold border border-blue-200 rounded py-1 bg-white hover:bg-blue-50">Preview KK</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endif

                    @if($letter->attachment_path)
                    <div class="mt-4">
                         <p class="text-sm text-gray-500 mb-2">Lampiran Dokumen</p>
                         <a href="{{ Storage::url($letter->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Lihat Lampiran
                         </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                 <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Status</h3>
                 
                 @if($letter->status == 'pending')
                    <div class="flex items-center space-x-2 text-yellow-600 bg-yellow-50 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold">Menunggu Verifikasi</span>
                    </div>
                 @elseif($letter->status == 'processed')
                    <div class="flex items-center space-x-2 text-blue-600 bg-blue-50 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold">Diproses (Menunggu Kades)</span>
                    </div>
                 @elseif($letter->status == 'verified')
                     <div class="flex items-center space-x-2 text-green-600 bg-green-50 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold">Selesai / Terbit</span>
                    </div>
                 @else
                     <div class="flex items-center space-x-2 text-red-600 bg-red-50 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="font-bold">Ditolak</span>
                    </div>
                 @endif

                 @if($letter->status == 'pending')
                 <div class="mt-6 space-y-3">
                     <form action="{{ route('operator.letters.process', $letter) }}" method="POST" id="processForm" onsubmit="confirmProcess(event)">
                        @csrf
                        <div class="mb-3">
                             <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan untuk Kades (Opsional)</label>
                             <textarea name="operator_notes" rows="2" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis catatan..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Proses & Teruskan
                        </button>
                     </form>
                     
                     <hr class="border-gray-100">

                     <button onclick="document.getElementById('rejectSection').classList.toggle('hidden')" class="w-full py-2.5 px-4 border border-red-300 rounded-lg shadow-sm text-sm font-bold text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        Tolak Permohonan
                     </button>
                     
                     <div id="rejectSection" class="hidden mt-3 bg-red-50 p-4 rounded-lg border border-red-100">
                         <form action="{{ route('operator.letters.reject', $letter) }}" method="POST" id="rejectForm" onsubmit="confirmReject(event)">
                            @csrf
                            <label class="block text-xs font-semibold text-red-700 mb-1">Alasan Penolakan</label>
                            <textarea name="reason" rows="2" required class="w-full text-sm border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 mb-2" placeholder="Wajib diisi..."></textarea>
                            <button type="submit" class="w-full py-2 px-4 rounded-lg text-xs font-bold text-white bg-red-600 hover:bg-red-700">
                                Konfirmasi Tolak
                            </button>
                         </form>
                     </div>
                 </div>
                 @endif

                  @if($letter->status == 'verified')
                    <div class="mt-6">
                        <a href="{{ route('operator.letters.download', $letter) }}" target="_blank" class="flex items-center justify-center w-full py-2.5 px-4 border border-blue-200 rounded-lg text-sm font-bold text-blue-700 bg-blue-50 hover:bg-blue-100">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Surat
                        </a>
                    </div>
                  @endif
            </div>

            <!-- Notes History -->
             @if($letter->operator_notes || $letter->rejection_reason)
            <div class="bg-gray-50 rounded-xl shadow-inner border border-gray-100 p-6">
                @if($letter->operator_notes)
                <div class="mb-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase">Catatan Operator</h4>
                    <p class="text-sm text-gray-800 mt-1 italic">"{{ $letter->operator_notes }}"</p>
                </div>
                @endif
                 @if($letter->rejection_reason)
                <div>
                    <h4 class="text-xs font-bold text-red-500 uppercase">Alasan Penolakan</h4>
                    <p class="text-sm text-red-700 mt-1 italic">"{{ $letter->rejection_reason }}"</p>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmProcess(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Proses Surat?',
            text: "Pastikan data sudah benar. Nomor surat akan digenerate otomatis!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.showLoading();
                document.getElementById('processForm').submit();
            }
        });
    }

    function confirmReject(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Tolak Permohonan?',
            text: "Apakah Anda yakin ingin menolak permohonan ini?",
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
