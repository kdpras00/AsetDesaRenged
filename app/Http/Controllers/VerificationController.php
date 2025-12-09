<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('public.verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Support verification_code, sha256_hash, or letter_number
        $letter = Letter::where('verification_code', strtoupper($request->code))
            ->orWhere('sha256_hash', strtolower($request->code))
            ->orWhere('letter_number', $request->code)
            ->with(['user', 'kepalaDesa', 'letterType', 'documentVerification'])
            ->first();

        if (!$letter) {
            return back()->with('error', 'Kode verifikasi tidak ditemukan. Pastikan kode yang Anda masukkan benar.');
        }

        // Redirect to the hash-based verification to enforce CAPTCHA and centralized logic
        // Ensure the letter has a hash, if not (legacy), we might need to handle it, but primarily we use the hash route.
        if ($letter->sha256_hash) {
             return redirect()->route('verification.verify.hash', ['hash' => $letter->sha256_hash]);
        }
        
        // Fallback for legacy letters without hash (if any), though typically they should have one.
        // In this case we might show result directly or generate hash. 
        // For consistency with specific request, we won't force captcha on legacy non-hash docs unless requested,
        // but the goal is to use the existing captcha page.
        
        if ($letter->status !== 'verified') {
            return back()->with('error', 'Surat ini belum diverifikasi atau ditolak.');
        }

        // Update verification count if using SHA-256 hash (redundant if redirected, but kept for fallback)
        if ($letter->documentVerification) {
            $letter->documentVerification->incrementVerifiedCount();
        }

        return view('public.verification-result', compact('letter'));
    }

    public function verifyByHash(string $hash)
    {
        // Check for Captcha session
        if (!session()->has('captcha_verified_' . $hash)) {
            return view('public.verification-captcha', compact('hash'));
        }

        $letter = Letter::where('sha256_hash', strtolower($hash))
            ->with(['user', 'kepalaDesa', 'letterType', 'documentVerification'])
            ->first();

        if (!$letter) {
            return view('public.verification-result', [
                'letter' => null,
                'error' => 'Dokumen tidak ditemukan atau hash tidak valid.'
            ]);
        }

        if ($letter->status !== 'verified') {
            return view('public.verification-result', [
                'letter' => null,
                'error' => 'Surat ini belum diverifikasi atau ditolak.'
            ]);
        }

        // Check if expired
        if ($letter->documentVerification && $letter->documentVerification->isExpired()) {
            return view('public.verification-result', [
                'letter' => $letter,
                'error' => 'Dokumen ini sudah kadaluarsa.'
            ]);
        }

        // Update verification count and audit trail
        if ($letter->documentVerification) {
            $letter->documentVerification->incrementVerifiedCount();
        }

        return view('public.verification-result', compact('letter'));
    }

    public function refreshCaptcha()
    {
        return response()->json(['img' => captcha_img('flat')]);
    }

    public function submitCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => 'required|captcha',
            'hash' => 'required'
        ]);

        session()->put('captcha_verified_' . $request->hash, true);

        return redirect()->route('verification.verify.hash', ['hash' => $request->hash]);
    }
}
