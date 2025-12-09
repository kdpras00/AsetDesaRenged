<?php

namespace App\Services;

use App\Models\Letter;
use Illuminate\Support\Facades\Config;

class DocumentHashService
{
    /**
     * Generate SHA-256 hash dari data surat
     * 
     * @param Letter $letter
     * @return string 64 character SHA-256 hash
     */
    public function generateHash(Letter $letter): string
    {
        // Data yang akan di-hash
        $dataToHash = [
            'letter_id' => $letter->id,
            'user_id' => $letter->user_id,
            'letter_type_id' => $letter->letter_type_id,
            'letter_number' => $letter->letter_number,
            'request_date' => $letter->request_date->format('Y-m-d'),
            'approved_date' => $letter->approved_date?->format('Y-m-d'),
            'secret_key' => config('app.document_secret_key'),
        ];

        // Generate SHA-256 hash
        $hash = hash('sha256', json_encode($dataToHash));

        return $hash;
    }

    /**
     * Verifikasi apakah hash valid untuk letter tertentu
     * 
     * @param string $hash
     * @param Letter $letter
     * @return bool
     */
    public function verifyHash(string $hash, Letter $letter): bool
    {
        $expectedHash = $this->generateHash($letter);
        return hash_equals($expectedHash, $hash);
    }

    /**
     * Generate verification URL dari hash
     * 
     * @param string $hash
     * @return string
     */
    public function generateVerificationUrl(string $hash): string
    {
        return route('verification.verify.hash', ['hash' => $hash]);
    }

    /**
     * Get partial hash untuk display (8 karakter pertama + ... + 8 karakter terakhir)
     * 
     * @param string $hash
     * @return string
     */
    public function getPartialHash(string $hash): string
    {
        if (strlen($hash) < 20) {
            return $hash;
        }
        
        return substr($hash, 0, 8) . '...' . substr($hash, -8);
    }
}
