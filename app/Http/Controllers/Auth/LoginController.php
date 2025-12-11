<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            $intendedUrl = session()->get('url.intended');
            
            // Prevent redirecting to background/API routes (like notifications)
            if ($intendedUrl && (str_contains($intendedUrl, 'notifications') || str_contains($intendedUrl, 'json'))) {
                session()->forget('url.intended');
            }

            if ($user->isOperator()) {
                return redirect()->intended('/operator/dashboard');
            } elseif ($user->isKepalaDesa()) {
                return redirect()->intended('/kepala-desa/dashboard');
            } else {
                return redirect()->intended('/warga/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
