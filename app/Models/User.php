<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'phone',
        'address',
        'rt_rw',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function processedLetters()
    {
        return $this->hasMany(Letter::class, 'operator_id');
    }

    public function verifiedLetters()
    {
        return $this->hasMany(Letter::class, 'kepala_desa_id');
    }

    public function approvedLoans()
    {
        return $this->hasMany(Loan::class, 'operator_id');
    }

    // Helper methods
    public function isOperator()
    {
        return $this->role === 'operator';
    }

    public function isWarga()
    {
        return $this->role === 'warga';
    }

    public function isKepalaDesa()
    {
        return $this->role === 'kepala_desa';
    }
}
