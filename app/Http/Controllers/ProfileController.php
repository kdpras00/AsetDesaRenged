<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'nik' => ['nullable', 'numeric', 'digits:16', Rule::unique('users')->ignore($user->id)],
            'kk' => ['nullable', 'numeric', 'digits:16', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'numeric', 'digits_between:10,13', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|max:1024', // 1MB Max
            'gender' => 'required|in:L,P',
            'birth_place' => ['required', 'string', 'max:255', 'regex:/^[^0-9]*$/'], // Prevent numbers
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:255',
            'job' => ['required', 'string', 'max:255', 'regex:/^[^0-9]*$/'], // Prevent numbers
            'address' => 'required|string|max:500',
        ], [
            'birth_place.regex' => 'Tempat lahir tidak boleh mengandung angka.',
            'job.regex' => 'Pekerjaan tidak boleh mengandung angka.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->kk = $request->kk;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->birth_place = $request->birth_place;
        $user->birth_date = $request->birth_date;
        $user->religion = $request->religion;
        $user->job = $request->job;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
