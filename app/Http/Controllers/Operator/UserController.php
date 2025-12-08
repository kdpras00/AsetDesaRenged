<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->get('role');
        
        $users = User::when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        return view('operator.users.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator,kepala_desa,warga',
            'nik' => 'nullable|string|max:20|unique:users',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('operator.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('operator.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,operator,kepala_desa,warga',
            'nik' => 'nullable|string|max:20|unique:users,nik,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('operator.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        
        // Prevent deleting associated data issues if needed, but basic delete for now
        $user->delete();

        return redirect()->route('operator.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
