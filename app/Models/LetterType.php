<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'requirements',
        'template',
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    // Relationships
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}
