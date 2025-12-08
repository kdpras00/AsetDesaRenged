@extends('layouts.app')

@section('title', 'Verifikasi Surat - Desa Renged')

@section('sidebar')
    @include('kepala-desa.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Verifikasi & Tanda Tangan</h1>
             <p class="text-gray-500 text-sm">Persetujuan akhir surat yang telah diproses operator.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <a href="{{ route('kepala-desa.letters.index', ['status' => 'processed']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'processed' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Menunggu Tanda Tangan
                </a>
            </li>
            <li class="mr-2">
                 <a href="{{ route('kepala-desa.letters.index', ['status' => 'history']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'history' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Riwayat Persetujuan
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">NO. SURAT & JENIS</th>
                        <th class="px-6 py-3">PEMOHON</th>
                        <th class="px-6 py-3">TANGGAL PROSES</th>
                        <th class="px-6 py-3">CATATAN OPERATOR</th>
                        <th class="px-6 py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($letters as $letter)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $letter->letterType->name }}</div>
                            <div class="text-xs text-blue-600 font-mono">{{ $letter->letter_number }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $letter->user->name }}
                            <div class="text-xs text-gray-500">{{ $letter->user->nik }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $letter->process_date ? \Carbon\Carbon::parse($letter->process_date)->translatedFormat('d M Y') : '-' }}
                            @if($letter->operator)
                                <div class="text-xs text-gray-400">Oleh: {{ $letter->operator->name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate italic text-gray-600">
                            "{{ $letter->operator_notes ?? '-' }}"
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($letter->status == 'processed')
                                <div class="flex justify-center space-x-2">
                                    <form id="verify-form-{{ $letter->id }}" action="{{ route('kepala-desa.letters.verify', $letter) }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="confirmVerify({{ $letter->id }})" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            ACC / Tanda Tangan
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal('{{ route('kepala-desa.letters.reject', $letter) }}')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Tolak
                                    </button>
                                </div>
                            @elseif($letter->status == 'verified')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Disetujui</span>
                                <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($letter->approved_date)->format('d/m/Y') }}</div>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada surat yang perlu diverifikasi saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $letters->appends(['status' => $status])->links() }}
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
             <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeRejectModal()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">Tolak Verifikasi Surat?</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <textarea name="reason" rows="3" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4" placeholder="Alasan penolakan / Revisi..."></textarea>
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Tolak Laporan
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmVerify(id) {
        Swal.fire({
            title: 'Setujui & Tanda Tangani?',
            text: "Surat akan diverifikasi dan QR Code akan digenerate yang berfungsi sebagai tanda tangan elektronik sah.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('verify-form-' + id).submit();
            }
        })
    }

    function openRejectModal(url) {
        document.getElementById('rejectForm').action = url;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
</script>
@endsection
