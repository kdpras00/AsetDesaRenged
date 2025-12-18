<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|numeric|digits:16|unique:users',
            'kk' => 'required|numeric|digits:16|unique:users',
            'phone' => 'required|numeric|digits_between:10,13|unique:users',
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan titik.',
            'email.unique' => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'kk.required' => 'Nomor Kartu Keluarga (KK) wajib diisi.',
            'kk.digits' => 'Nomor KK harus berjumlah 16 digit.',
            'kk.unique' => 'Nomor KK ini sudah terdaftar.',
            'phone.unique' => 'Nomor WhatsApp ini sudah digunakan oleh akun lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'warga', // Default role untuk registrasi public
            'nik' => $validated['nik'],
            'kk' => $validated['kk'],
            'phone' => $validated['phone'],
        ]);

        Auth::login($user);

        return redirect('/profile')->with('warning', 'Registrasi berhasil! Mohon lengkapi biodata Anda sebelum mengajukan surat.');
    }
}
