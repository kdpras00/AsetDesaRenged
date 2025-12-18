<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    /**
     * Generate QR code image dari URL
     * 
     * @param string $url URL yang akan di-encode ke QR code
     * @param string $filename Nama file untuk QR code (tanpa extension)
     * @return string Path ke QR code image di storage
     */
    public function generate(string $url, string $filename): string
    {
        // Pastikan directory exists
        $directory = 'qrcodes';
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Generate QR code
        $qrCodeImage = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H') // High error correction untuk scan yang lebih reliable
            ->generate($url);

        // Save ke storage
        $path = $directory . '/' . $filename . '.svg';
        Storage::disk('public')->put($path, $qrCodeImage);

        return $path;
    }

    /**
     * Generate QR code dan return sebagai base64 string (untuk embed langsung ke PDF)
     * 
     * @param string $url
     * @return string Base64 encoded SVG image
     */
    public function generateBase64(string $url): string
    {
        $qrCodeImage = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($url);

        return base64_encode($qrCodeImage);
    }

    /**
     * Delete QR code image dari storage
     * 
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}
