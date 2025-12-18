<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'requirements',
        'template',
        'form_config',
    ];

    protected $casts = [
        'requirements' => 'array',
        'form_config' => 'array',
    ];

    // Relationships
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}
