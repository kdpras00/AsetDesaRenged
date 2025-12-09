<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\User;
use App\Notifications\LetterVerified;
use App\Notifications\RequestRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LetterVerificationController extends Controller
{
    /**
     * Display a listing of letters pending verification.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'processed');

        $letters = Letter::with(['user', 'letterType', 'operator'])
            ->when($status, function ($query) use ($status) {
                if ($status === 'history') {
                    return $query->whereIn('status', ['verified', 'rejected']);
                }
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('kepala-desa.letters.index', compact('letters', 'status'));
    }

    /**
     * Verify and sign the letter.
     */
    public function verify(Request $request, Letter $letter)
    {
        if ($letter->status !== 'processed') {
            return back()->with('error', 'Hanya surat yang sudah diproses admin yang dapat diverifikasi.');
        }

        // Update letter status
        $letter->update([
            'status' => 'verified',
            'kepala_desa_id' => auth()->id(),
            'approved_date' => now(),
        ]);

        // Generate SHA-256 hash and QR code
        try {
            $letter->generateSHA256Hash();
        } catch (\Exception $e) {
            \Log::error('Failed to generate SHA-256 hash for letter: ' . $e->getMessage());
            return back()->with('warning', 'Surat berhasil diverifikasi, namun gagal generate QR code. Silakan hubungi admin.');
        }

        // Notify Warga
        $letter->user->notify(new LetterVerified($letter));

        // Notify Operator (Optional, but good for tracking)
        $operators = User::where('role', 'operator')->get();
        Notification::send($operators, new LetterVerified($letter));

        return redirect()->back()->with('success', 'Surat berhasil diverifikasi dan QR code telah di-generate.');
    }

    /**
     * Reject the letter.
     */
    public function reject(Request $request, Letter $letter)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        if ($letter->status !== 'processed') {
            return back()->with('error', 'Status surat tidak valid.');
        }

        $letter->update([
            'status' => 'rejected',
            'kepala_desa_id' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        // Notify Warga
        $letter->user->notify(new RequestRejected(
            'Permohonan surat ' . $letter->letterType->name . ' ditolak oleh Kepala Desa: ' . $request->reason,
            route('warga.letters.index', ['view' => 'history'])
        ));

        return redirect()->back()->with('success', 'Pengajuan surat ditolak.');
    }
}
