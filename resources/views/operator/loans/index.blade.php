@extends('layouts.app')

@section('title', 'Approval Peminjaman - Desa Renged')

@section('sidebar')
    @include('operator.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div>
             <h1 class="text-2xl font-bold text-gray-900">Peminjaman Aset</h1>
             <p class="text-gray-500 text-sm">Kelola pengajuan dan pengembalian aset desa.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <a href="{{ route('operator.loans.index', ['status' => 'pending']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'pending' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Menunggu Approval
                </a>
            </li>
            <li class="mr-2">
                <a href="{{ route('operator.loans.index', ['status' => 'approved']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'approved' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                    Sedang Dipinjam
                </a>
            </li>
            <li class="mr-2">
                 <a href="{{ route('operator.loans.index', ['status' => 'history']) }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ $status == 'history' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
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
                        <th class="px-6 py-3">PEMINJAM</th>
                        <th class="px-6 py-3">ASET & JUMLAH</th>
                        <th class="px-6 py-3">TANGGAL PINJAM</th>
                        <th class="px-6 py-3">KEPERLUAN</th>
                        <th class="px-6 py-3 text-center">STATUS</th>
                        <th class="px-6 py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($loans as $loan)
                    @php
                        $rentableStock = $loan->asset->rentable_stock;
                        // For pending loans, the rentable stock logic (Total - Pending - Approved) ALREADY subtracts this pending loan.
                        // So to check if there is ENOUGH for THIS loan, we need to add it back to see the pool available for it.
                        // Wait, if rentable_stock is calculated as (Total - All Pending & Approved),
                        // then if rentable_stock >= 0, it means we are good?
                        // Actually no. If Total=10, Pending=1 (this one). Rentable = 9.
                        // We want to know if 1 <= 10. Yes.
                        // If Total=1, Pending=1 (this one). Rentable = 0.
                        // We want to know if 1 <= 1. Yes.
                        // If Total=1, Pending=2 (this one + another). Rentable = -1.
                        // We want to know if 1 <= (1 - 1 other) = 0? No.
                        
                        // Let's use the logic: available_for_this = rentable_stock + quantity_of_this_loan.
                        // If available_for_this < loan->quantity, then Warning.
                        // Simplification: valid if rentable_stock >= 0 ??
                        // If Rentable is -1, it means we are short 1.
                        // So yes, generally if rentable_stock < 0, we have a problem.
                        
                        // Let's stick to the controller logic for consistency:
                        // currentUsage = Other Loans (Pending/Approved)
                        // available = Total - currentUsage
                        // if available < quantity -> Warning.
                        
                        $otherActiveLoans = \App\Models\Loan::where('asset_id', $loan->asset_id)
                            ->where('id', '!=', $loan->id)
                            ->whereIn('status', ['approved', 'pending'])
                            ->sum('quantity');
                        $availableForThis = $loan->asset->quantity - $otherActiveLoans;
                        $isStockInsufficient = $availableForThis < $loan->quantity;
                    @endphp
                    <tr class="bg-white hover:bg-gray-50 transition-colors {{ $isStockInsufficient && $loan->status == 'pending' ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $loan->user->name }}
                            <div class="text-xs text-gray-500">{{ $loan->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $loan->asset->name }}</span>
                            <div class="text-xs text-blue-600 mb-1">Jml: {{ $loan->quantity }} Unit</div>
                            
                            @if($loan->status == 'pending')
                                <div class="text-xs font-semibold {{ $isStockInsufficient ? 'text-red-600' : 'text-green-600' }}">
                                    Stok: {{ $availableForThis }} Unit
                                    @if($isStockInsufficient)
                                        <span class="block text-red-700 font-bold mt-1">⚠️ Stok Kurang!</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('d M Y') }}</div>
                            <div class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($loan->return_date)->translatedFormat('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $loan->purpose }}">
                            {{ $loan->purpose }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($loan->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            @elseif($loan->status == 'approved')
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">Dipinjam</span>
                            @elseif($loan->status == 'returning')
                                <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2.5 py-0.5 rounded border border-purple-200">Pengajuan Kembali</span>
                            @elseif($loan->status == 'returned')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Dikembalikan</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($loan->status == 'pending')
                                <div class="flex justify-center space-x-2">
                                    <form action="{{ route('operator.loans.approve', $loan) }}" method="POST" id="approve-form-{{ $loan->id }}">
                                        @csrf
                                        <button type="button" onclick="confirmApprove({{ $loan->id }})" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                            Terima
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal('{{ route('operator.loans.reject', $loan) }}')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Tolak
                                    </button>
                                </div>
                            @elseif($loan->status == 'approved')
                                <form action="{{ route('operator.loans.return', $loan) }}" method="POST" id="return-form-{{ $loan->id }}">
                                    @csrf
                                    <button type="button" onclick="confirmReturn({{ $loan->id }})" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Terima Kembali
                                    </button>
                                </form>
                            @elseif($loan->status == 'returning')
                                <div class="flex justify-center space-x-2">
                                    <form action="{{ route('operator.loans.return', $loan) }}" method="POST" id="return-form-{{ $loan->id }}">
                                        @csrf
                                        <button type="button" onclick="confirmReturn({{ $loan->id }})" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                            Setujui Kembali
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal('{{ route('operator.loans.reject', $loan) }}')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none transition">
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data peminjaman di kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $loans->appends(['status' => $status])->links() }}
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
                <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Alasan Penolakan Peminjaman</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <textarea name="reason" rows="3" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4" placeholder="Tulis alasan penolakan..."></textarea>
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Tolak Peminjaman
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openRejectModal(url) {
        document.getElementById('rejectForm').action = url;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }

    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Peminjaman?',
            text: "Aset akan dipinjamkan kepada pemohon",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('approve-form-' + id).submit();
            }
        })
    }

    function confirmReturn(id) {
        Swal.fire({
            title: 'Konfirmasi Pengembalian?',
            text: "Aset telah dikembalikan oleh peminjam",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Terima Kembali!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + id).submit();
            }
        })
    }
</script>
@endsection
