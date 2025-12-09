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

                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'kematian'))
                <!-- Section: Data Jenazah (Khusus Surat Kematian) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Jenazah & Kematian
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama Jenazah -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap Jenazah <span class="text-red-500">*</span></label>
                            <input type="text" name="deceased_name" required value="{{ old('deceased_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Nama Almarhum/Almarhumah">
                        </div>

                        <!-- NIK Jenazah -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">NIK Jenazah <span class="text-red-500">*</span></label>
                            <input type="text" name="deceased_nik" required value="{{ old('deceased_nik') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="16 digit NIK">
                        </div>

                        <!-- No KK Jenazah -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nomor KK Jenazah</label>
                            <input type="text" name="deceased_kk" value="{{ old('deceased_kk', '-') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Nomor KK (Opsional)">
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="deceased_birth_place" required value="{{ old('deceased_birth_place') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="deceased_birth_date" required value="{{ old('deceased_birth_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>

                        <!-- Umur -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Umur (Tahun) <span class="text-red-500">*</span></label>
                            <input type="number" name="deceased_age" required value="{{ old('deceased_age') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>

                        <!-- Alamat Jenazah -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Terakhir <span class="text-red-500">*</span></label>
                            <textarea name="deceased_address" rows="2" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('deceased_address') }}</textarea>
                        </div>
                        
                        <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                        <!-- Hari Meninggal -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Hari Meninggal <span class="text-red-500">*</span></label>
                            <select name="death_day" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ old('death_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Meninggal -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Meninggal <span class="text-red-500">*</span></label>
                            <input type="date" name="death_date" required value="{{ old('death_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>

                        <!-- Meninggal di -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Meninggal di <span class="text-red-500">*</span></label>
                            <input type="text" name="death_place" required value="{{ old('death_place', 'Rumah') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: Rumah / RSUD Tangerang">
                        </div>

                        <!-- Penyebab -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Penyebab Kematian <span class="text-red-500">*</span></label>
                            <input type="text" name="death_cause" required value="{{ old('death_cause', 'Sakit') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: Sakit / Kecelakaan">
                        </div>
                        
                        <!-- Hubungan Pelapor -->
                        <div class="md:col-span-2">
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Hubungan Pelapor dengan Jenazah <span class="text-red-500">*</span></label>
                            <input type="text" name="reporter_relationship" required value="{{ old('reporter_relationship') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: Suami / Istri / Anak / Ketua RT">
                        </div>
                    </div>
                </div>
                @endif

                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'usaha'))
                <!-- Section: Data Usaha (Khusus Surat Keterangan Usaha) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Usaha
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama Usaha -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Usaha <span class="text-red-500">*</span></label>
                            <input type="text" name="business_name" required value="{{ old('business_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: PRAKTEK PAK BINDHI">
                        </div>

                        <!-- Jenis Usaha -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Usaha <span class="text-red-500">*</span></label>
                            <input type="text" name="business_type" required value="{{ old('business_type') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: Pengobatan Tradisional">
                        </div>

                        <!-- Alamat Usaha -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Usaha <span class="text-red-500">*</span></label>
                            <textarea name="business_address" rows="2" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Alamat lengkap tempat usaha">{{ old('business_address') }}</textarea>
                        </div>
                    </div>
                </div>
                @endif

                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'cuti') || \Illuminate\Support\Str::contains(strtolower($type->name), 'ijin'))
                <!-- Section: Data Ijin Cuti (Khusus Surat Keterangan Ijin Cuti) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Cuti / Ijin
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <!-- Nama Perusahaan -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Perusahaan / Instansi <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name" required value="{{ old('company_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: PT. PWI 2">
                        </div>

                        <!-- Hari Cuti -->
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Hari Cuti <span class="text-red-500">*</span></label>
                            <select name="leave_day" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ old('leave_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Cuti -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Cuti <span class="text-red-500">*</span></label>
                            <input type="date" name="leave_date" required value="{{ old('leave_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>

                        <!-- Maksud Tujuan -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Maksud / Tujuan Cuti <span class="text-red-500">*</span></label>
                            <input type="text" name="leave_purpose" required value="{{ old('leave_purpose') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: Melangsungkan Khitanan / Pernikahan">
                        </div>
                        
                         <!-- Nama Anak (Optional if relevant) -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Anak / Keterangan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="child_name" value="{{ old('child_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Contoh: MOH. NAUFAL ARRASYID">
                        </div>
                    </div>
                </div>
                @endif
                
                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'kelahiran'))
                <!-- Section: Data Kelahiran (Khusus Surat Keterangan Kelahiran) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Kelahiran
                    </div>

                    <!-- Sub-section: Data Anak -->
                    <h5 class="text-md font-bold text-gray-800 border-b pb-2 mb-4 mt-2">A. Data Anak</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Anak <span class="text-red-500">*</span></label>
                            <input type="text" name="child_name" required value="{{ old('child_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 uppercase">
                        </div>
                        <div>
                             <label class="block mb-2 text-sm font-semibold text-gray-700">NIK Anak <span class="text-red-500">*</span></label>
                            <input type="text" name="child_nik" required value="{{ old('child_nik') }}" maxlength="16"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        </div>
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                             <select name="child_gender" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                <option value="L" {{ old('child_gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('child_gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                         <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="child_birth_place" required value="{{ old('child_birth_place') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="child_birth_date" required value="{{ old('child_birth_date') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Anak <span class="text-red-500">*</span></label>
                            <textarea name="child_address" rows="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('child_address') }}</textarea>
                        </div>
                    </div>

                    <!-- Sub-section: Data Suami -->
                    <h5 class="text-md font-bold text-gray-800 border-b pb-2 mb-4">B. Data Suami (Ayah)</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="father_name" required value="{{ old('father_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 uppercase">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="father_birth_place" required value="{{ old('father_birth_place') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="father_birth_date" required value="{{ old('father_birth_date') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="father_address" rows="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('father_address') }}</textarea>
                        </div>
                    </div>

                    <!-- Sub-section: Data Istri -->
                    <h5 class="text-md font-bold text-gray-800 border-b pb-2 mb-4">C. Data Istri (Ibu)</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="mother_name" required value="{{ old('mother_name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 uppercase">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="mother_birth_place" required value="{{ old('mother_birth_place') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="mother_birth_date" required value="{{ old('mother_birth_date') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="mother_address" rows="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('mother_address') }}</textarea>
                        </div>
                    </div>

                </div>
                @endif


                
                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'domisili'))
                <!-- Section: Data Domisili (Khusus Surat Keterangan Domisili) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Domisili
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-2">
                        <!-- Alamat Sebelumnya -->
                        <div>
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Sebelumnya <span class="text-red-500">*</span></label>
                            <textarea name="previous_address" rows="2" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Alamat lengkap sebelum pindah domisili">{{ old('previous_address') }}</textarea>
                        </div>
                        <!-- Alamat Domisili Sekarang -->
                        <div>
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Domisili Sekarang <span class="text-red-500">*</span></label>
                            <textarea name="domicile_address" rows="2" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Alamat lengkap domisili saat ini">{{ old('domicile_address') }}</textarea>
                        </div>
                    </div>
                </div>
                @endif


                
                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'tidak mampu'))
                <!-- Section: Data Orang Tua (Khusus Surat Keterangan Tidak Mampu) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Orang Tua
                    </div>

                    <!-- Ayah -->
                    <div class="mt-4">
                        <h4 class="font-bold text-gray-700 border-b pb-2 mb-4">Data Ayah</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="father_name" required value="{{ old('father_name') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">NIK Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="father_nik" required value="{{ old('father_nik') }}" maxlength="16"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="father_job" required value="{{ old('father_job') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div class="md:col-span-2">
                                 <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Ayah <span class="text-red-500">*</span></label>
                                <textarea name="father_address" rows="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('father_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Ibu -->
                    <div class="mt-6">
                        <h4 class="font-bold text-gray-700 border-b pb-2 mb-4">Data Ibu</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="mother_name" required value="{{ old('mother_name') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">NIK Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="mother_nik" required value="{{ old('mother_nik') }}" maxlength="16"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-700">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="mother_job" required value="{{ old('mother_job') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>
                            <div class="md:col-span-2">
                                 <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Ibu <span class="text-red-500">*</span></label>
                                <textarea name="mother_address" rows="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('mother_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                @endif


                
                @if(\Illuminate\Support\Str::contains(strtolower($type->name), 'ktp'))
                <!-- Section: Data Permohonan KTP (Khusus Formulir KTP) -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative mt-8">
                     <div class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-blue-600 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 text-xs">2</span>
                        Data Permohonan KTP
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-2">
                        <!-- Jenis Permohonan -->
                        <div>
                             <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Permohonan <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center space-x-2 border p-3 rounded-lg w-full hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="ktp_type" value="Baru" class="text-blue-600 focus:ring-blue-500" {{ old('ktp_type') == 'Baru' ? 'checked' : '' }} required>
                                    <span class="text-gray-700 text-sm">A. Baru</span>
                                </label>
                                <label class="flex items-center space-x-2 border p-3 rounded-lg w-full hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="ktp_type" value="Perpanjangan" class="text-blue-600 focus:ring-blue-500" {{ old('ktp_type') == 'Perpanjangan' ? 'checked' : '' }}>
                                    <span class="text-gray-700 text-sm">B. Perpanjangan</span>
                                </label>
                                 <label class="flex items-center space-x-2 border p-3 rounded-lg w-full hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="ktp_type" value="Penggantian" class="text-blue-600 focus:ring-blue-500" {{ old('ktp_type') == 'Penggantian' ? 'checked' : '' }}>
                                    <span class="text-gray-700 text-sm">C. Penggantian</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


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
