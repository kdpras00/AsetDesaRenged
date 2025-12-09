<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operator_id',
        'kepala_desa_id',
        'letter_type_id',
        'letter_number',
        'purpose',
        'request_date',
        'process_date',
        'approved_date',
        'status',
        'qr_code',
        'verification_code',
        'sha256_hash',
        'operator_notes',
        'rejection_reason',
        'attachment',
        'data',
    ];

    protected $casts = [
        'request_date' => 'date',
        'process_date' => 'date',
        'approved_date' => 'date',
        'data' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function kepalaDesa()
    {
        return $this->belongsTo(User::class, 'kepala_desa_id');
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function documentVerification()
    {
        return $this->hasOne(DocumentVerification::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // Helper methods
    public function generateVerificationCode()
    {
        $this->verification_code = strtoupper(Str::random(12));
        $this->save();
        return $this->verification_code;
    }

    public function generateQRCode()
    {
        if (!$this->verification_code) {
            $this->generateVerificationCode();
        }

        $url = url('/verify?code=' . $this->verification_code);
        $filename = 'qr_' . $this->verification_code . '.png';
        $path = storage_path('app/public/qrcodes/' . $filename);

        // Create directory if not exists
        if (!file_exists(storage_path('app/public/qrcodes'))) {
            mkdir(storage_path('app/public/qrcodes'), 0755, true);
        }

        QrCode::format('png')
            ->size(300)
            ->generate($url, $path);

        $this->qr_code = 'qrcodes/' . $filename;
        $this->save();

        return $this->qr_code;
    }

    public function generateSHA256Hash()
    {
        $hashService = new \App\Services\DocumentHashService();
        $qrService = new \App\Services\QRCodeService();

        // Generate SHA-256 hash
        $hash = $hashService->generateHash($this);
        
        // Generate verification URL
        $verificationUrl = $hashService->generateVerificationUrl($hash);
        
        // Generate QR code
        $qrCodePath = $qrService->generate($verificationUrl, 'qr_' . $hash);
        
        // Save hash ke letter
        $this->sha256_hash = $hash;
        $this->qr_code = $qrCodePath;
        $this->save();
        
        // Create document verification record
        $this->documentVerification()->create([
            'sha256_hash' => $hash,
            'verification_url' => $verificationUrl,
            'issued_at' => now(),
            'expires_at' => null, // No expiry by default
        ]);
        
        return $hash;
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }
}
