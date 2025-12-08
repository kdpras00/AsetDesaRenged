<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVerification extends Model
{
    protected $fillable = [
        'letter_id',
        'sha256_hash',
        'verification_url',
        'issued_at',
        'expires_at',
        'verified_count',
        'last_verified_at',
        'last_verified_ip',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_verified_at' => 'datetime',
        'verified_count' => 'integer',
    ];

    // Relationships
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    // Helper methods
    public function incrementVerifiedCount(string $ipAddress = null)
    {
        $this->verified_count++;
        $this->last_verified_at = now();
        $this->last_verified_ip = $ipAddress ?? request()->ip();
        $this->save();
    }

    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        return $this->expires_at < now();
    }
}
