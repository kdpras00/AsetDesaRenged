@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('sidebar')
    @if(auth()->user()->role == 'warga')
        @include('warga.sidebar')
    @elseif(auth()->user()->role == 'operator')
        @include('operator.sidebar')
    @elseif(auth()->user()->role == 'kepala_desa')
        @include('kepala-desa.sidebar')
    @endif
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Profil</h1>
        <p class="mt-2 text-sm text-gray-600">Kelola informasi pribadi dan keamanan akun Anda dalam satu tempat.</p>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start space-x-3 transition-all duration-300">
        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <div class="flex-1">
            <h3 class="text-sm font-medium text-green-800">Berhasil</h3>
            <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-green-500 hover:text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Edit Profile (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Pribadi</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui foto dan detail data diri Anda.</p>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Avatar Section -->
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="relative group">
                            @if(auth()->user()->avatar)
                                <img id="avatar-preview" class="h-24 w-24 object-cover rounded-full ring-4 ring-white shadow-lg border border-gray-200" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile photo" />
                            @else
                                <div id="avatar-placeholder" class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-lg border border-gray-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <!-- Preview Image Element (Hidden by default) -->
                            <img id="new-avatar-preview" class="hidden h-24 w-24 object-cover rounded-full ring-4 ring-white shadow-lg border border-gray-200" />
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            <label class="block text-sm font-medium text-gray-900 mb-2">Foto Profil</label>
                            <div class="flex flex-col sm:flex-row gap-3 items-center">
                                <label for="avatar-input" class="cursor-pointer bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Pilih Foto Baru
                                </label>
                                <span class="text-xs text-gray-500">JPG, PNG atau GIF (Maks. 1MB)</span>
                            </div>
                            <input id="avatar-input" type="file" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                            @error('avatar') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-8"></div>

                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required readonly
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-gray-100 text-gray-500 cursor-not-allowed">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- KK -->
                        <div>
                            <label for="kk" class="block text-sm font-semibold text-gray-700 mb-1">No. KK <span class="text-red-500">*</span></label>
                            <input type="text" name="kk" id="kk" value="{{ old('kk', $user->kk) }}" required
                                maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                            @error('kk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $user->nik) }}" required
                                maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                            @error('nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                                <option value="">- Pilih -</option>
                                <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Religion -->
                        <div>
                            <label for="religion" class="block text-sm font-semibold text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                            <select name="religion" id="religion" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                                <option value="">- Pilih -</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}" {{ old('religion', $user->religion) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                            @error('religion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birth Info Group -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                             <div>
                                <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $user->birth_place) }}" required
                                    oninput="this.value = this.value.replace(/[0-9]/g, '')"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                                @error('birth_place') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                @php
                                    $birthDate = $user->birth_date;
                                    if ($birthDate instanceof \DateTime) {
                                        $birthDate = $birthDate->format('Y-m-d');
                                    }
                                @endphp
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $birthDate) }}" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                                @error('birth_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Job -->
                        <div>
                            <label for="job" class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                            <input type="text" name="job" id="job" value="{{ old('job', $user->job) }}" required
                                oninput="this.value = this.value.replace(/[0-9]/g, '')"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                            @error('job') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp / Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                                maxlength="13" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="3" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">{{ old('address', $user->address) }}</textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition-all transform hover:scale-[1.02]">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Password & Account Security (4 cols) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Password Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-900">Keamanan</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui password akun Anda.</p>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors text-sm py-2.5 px-4 bg-white">
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all shadow-md">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('new-avatar-preview');
                var currentAvatar = document.getElementById('avatar-preview');
                var placeholder = document.getElementById('avatar-placeholder');
                
                if(currentAvatar) currentAvatar.classList.add('hidden');
                if(placeholder) placeholder.classList.add('hidden');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

@push('scripts')
<script>
    @if(empty($user->gender) || empty($user->birth_place) || empty($user->birth_date) || empty($user->religion) || empty($user->job))
        Swal.fire({
            icon: 'warning',
            title: 'Lengkapi Biodata',
            text: 'Mohon lengkapi data diri Anda (Jenis Kelamin, TTL, Agama, Pekerjaan) agar dapat mengajukan surat.',
            confirmButtonText: 'Baik, Saya Lengkapi',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>
@endpush
