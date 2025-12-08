<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
        <h2 class="font-bold text-gray-800 text-lg">Riwayat Pengajuan Surat</h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-blue-200">{{ $letters->total() }} Pengajuan</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Jenis Surat</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Keperluan</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($letters as $letter)
                <tr class="bg-white hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-4">
                         <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 border border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $letter->type->name ?? 'Jenis Surat Tidak Diketahui' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5 font-mono">{{ $letter->code ?? 'Kode Belum Terbit' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ \Carbon\Carbon::parse($letter->created_at)->format('H:i') }} WIB
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700 text-sm line-clamp-2 max-w-xs" title="{{ $letter->purpose }}">
                            {{ Str::limit($letter->purpose, 50) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($letter->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-2 h-2 rounded-full bg-yellow-400 mr-1.5"></span>
                                Menunggu
                            </span>
                        @elseif($letter->status == 'verified')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-1.5"></span>
                                Verifikasi Admin
                            </span>
                        @elseif($letter->status == 'approved')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
                                Siap Diambil
                            </span>
                        @elseif($letter->status == 'rejected')
                            <div class="flex flex-col items-start">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    <span class="w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
                                    Ditolak
                                </span>
                                @if($letter->rejection_reason)
                                    <span class="text-xs text-red-600 mt-1 max-w-xs truncate" title="{{ $letter->rejection_reason }}">
                                        "{{ Str::limit($letter->rejection_reason, 30) }}"
                                    </span>
                                @endif
                            </div>
                        @else
                             <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                {{ ucfirst($letter->status) }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center bg-gray-50">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-gray-900 font-bold mb-1">Belum Ada Pengajuan</h3>
                            <p class="text-gray-500 text-sm mb-4">Anda belum pernah mengajukan surat keterangan.</p>
                            <a href="{{ route('warga.letters.index', ['view' => 'catalog']) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                                Buat Pengajuan Baru
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($letters->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $letters->appends(['view' => 'history'])->links() }}
    </div>
    @endif
</div>
