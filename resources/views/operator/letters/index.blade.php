@extends('layouts.app')

@section('title', 'Verifikasi Surat - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Layanan Surat Desa</h1>
             <p class="text-gray-500 text-sm">Verifikasi administrasi pengajuan surat warga.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <a href="{{ route('operator.letters.index', ['status' => 'pending']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'pending' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Menunggu Verifikasi
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('operator.letters.index', ['status' => 'processed']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'processed' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Diproses (Menunggu Kades)
                </a>
            </li>
            <li class="mr-2">
                 <a href="{{ route('operator.letters.index', ['status' => 'history']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'history' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Riwayat
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
                        <th class="px-6 py-3">PEMOHON</th>
                        <th class="px-6 py-3">JENIS SURAT</th>
                        <th class="px-6 py-3">TANGGAL PENGAJUAN</th>
                        <th class="px-6 py-3">KEPERLUAN</th>
                        <th class="px-6 py-3 text-center">STATUS</th>
                        <th class="px-6 py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($letters as $letter)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $letter->user->name }}
                            <div class="text-xs text-gray-500">{{ $letter->user->nik }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $letter->letterType->name }}</span>
                            @if($letter->letter_number)
                                <div class="text-xs text-blue-600 font-mono">{{ $letter->letter_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($letter->request_date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate">
                            {{ $letter->purpose }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($letter->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            @elseif($letter->status == 'processed')
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">Paraf Operator</span>
                            @elseif($letter->status == 'verified')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($letter->status == 'pending')
                                <div class="flex justify-center space-x-2">
                                    <button type="button" onclick="openProcessModal('{{ route('operator.letters.process', $letter) }}')" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Proses
                                    </button>
                                    <button type="button" onclick="openRejectModal('{{ route('operator.letters.reject', $letter) }}')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Tolak
                                    </button>
                                </div>
                            @elseif($letter->status == 'verified')
                                <a href="{{ route('operator.letters.download', $letter) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Unduh</a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data surat di kategori ini.
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

<!-- Process/Approve Modal -->
<div id="processModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeProcessModal()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
            <div class="p-6">
                <h3 class="mb-4 text-xl font-bold text-gray-900">Verifikasi & Terbitkan Nomor</h3>
                <form id="processForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Surat Resmi</label>
                        <input type="text" name="letter_number" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 font-mono" placeholder="470/001/DS/RM/2025">
                        <p class="mt-1 text-xs text-gray-500">Nomor ini akan tertera pada surat final.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Catatan (Opsional)</label>
                        <textarea name="operator_notes" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Catatan untuk Kepala Desa"></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Simpan & Teruskan ke Kades
                    </button>
                </form>
            </div>
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
                <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">Tolak Permohonan Surat?</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <textarea name="reason" rows="3" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4" placeholder="Tulis alasan penolakan..."></textarea>
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Tolak
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openProcessModal(url) {
        document.getElementById('processForm').action = url;
        document.getElementById('processModal').classList.remove('hidden');
        document.getElementById('processModal').classList.add('flex');
    }
    
    function closeProcessModal() {
        document.getElementById('processModal').classList.add('hidden');
        document.getElementById('processModal').classList.remove('flex');
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
