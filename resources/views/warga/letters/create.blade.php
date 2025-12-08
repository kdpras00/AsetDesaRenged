@extends('layouts.app')

@section('title', 'Ajukan Surat - Desa Renged')

@section('sidebar')
    @include('warga.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-4 text-sm text-gray-500">
        <a href="{{ route('warga.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('warga.letters.index') }}" class="hover:text-blue-600">Layanan Surat</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Form Pengajuan</span>
    </nav>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-xl font-bold text-gray-900">Form Pengajuan Surat</h1>
            <p class="text-gray-500 text-sm mt-1">Silakan lengkapi data permohonan surat di bawah ini.</p>
        </div>

        <div class="p-8">
            <!-- Letter Type Info -->
             <div class="flex items-start bg-blue-50/50 p-6 rounded-xl border border-blue-100 mb-8 shadow-sm">
                 <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-4 flex-shrink-0 border border-blue-200 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                     <h3 class="text-lg font-bold text-gray-900">{{ $type->name }}</h3>
                     <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $type->description ?? 'Pastikan data diri Anda sudah benar sebelum mengajukan.' }}</p>
                </div>
            </div>

            <form action="{{ route('warga.letters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <input type="hidden" name="letter_type_id" value="{{ $type->id }}">

                <!-- Section 1: Data Pemohon -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">1</span>
                        Data Pemohon (Otomatis)
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama -->
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" value="{{ auth()->user()->name }}" readonly 
                                    class="bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-lg block w-full pl-10 p-3 cursor-not-allowed">
                            </div>
                        </div>

                        <!-- NIK -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <input type="text" value="{{ auth()->user()->nik ?? '-' }}" readonly 
                                    class="bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-lg block w-full pl-10 p-3 cursor-not-allowed font-mono">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail Permohonan -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Detail Permohonan
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-2">
                        <!-- Keperluan -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Keperluan Pengajuan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <textarea name="purpose" rows="4" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all focus:bg-white placeholder-gray-400" placeholder="Contoh: Untuk persyaratan mendaftar sekolah anak / melamar pekerjaan.">{{ old('purpose') }}</textarea>
                            </div>
                        </div>

                        <!-- Lampiran -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Lampiran Dokumen (Opsional)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG (MAX. 5MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="attachment" class="hidden" onchange="previewFile(this)" />
                                </label>
                            </div>
                             <div id="file-preview" class="mt-4 hidden p-3 bg-blue-50 border border-blue-100 rounded-lg flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span id="filename-preview" class="text-sm text-blue-800 font-medium truncate">Filename.pdf</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('warga.letters.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition focus:ring-4 focus:ring-gray-100">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl focus:ring-4 focus:ring-blue-300">Kirim Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFile(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            document.getElementById('filename-preview').textContent = file.name;
            document.getElementById('file-preview').classList.remove('hidden');
        }
    }
</script>
@endsection
