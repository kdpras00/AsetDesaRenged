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
            'phone' => 'required|numeric|digits_between:10,13',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'warga', // Default role untuk registrasi public
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
        ]);

        Auth::login($user);

        return redirect('/profile')->with('warning', 'Registrasi berhasil! Mohon lengkapi biodata Anda sebelum mengajukan surat.');
    }
}
