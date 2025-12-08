<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of letters.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $letters = Letter::with(['user', 'letterType'])
            ->when($status, function ($query) use ($status) {
                if ($status === 'history') {
                    return $query->whereIn('status', ['verified', 'rejected']);
                }
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('operator.letters.index', compact('letters', 'status'));
    }

    /**
     * Process/Verify the letter administratively.
     */
    public function process(Request $request, Letter $letter)
    {
        $request->validate([
            'letter_number' => 'required|string|unique:letters,letter_number,' . $letter->id,
            'operator_notes' => 'nullable|string',
        ]);

        if ($letter->status !== 'pending') {
            return back()->with('error', 'Hanya surat pending yang dapat diproses.');
        }

        $letter->update([
            'status' => 'processed',
            'letter_number' => $request->letter_number,
            'operator_id' => auth()->id(),
            'process_date' => now(),
            'operator_notes' => $request->operator_notes,
        ]);

        return redirect()->back()->with('success', 'Surat berhasil diproses dan diteruskan ke Kepala Desa.');
    }

    /**
     * Reject the letter request.
     */
    public function reject(Request $request, Letter $letter)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        if ($letter->status !== 'pending') {
            return back()->with('error', 'Status surat tidak valid untuk ditolak.');
        }

        $letter->update([
            'status' => 'rejected',
            'operator_id' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat ditolak.');
    }
}
