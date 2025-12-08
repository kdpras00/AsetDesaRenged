<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'description',
        'condition',
        'purchase_date',
        'purchase_price',
        'location',
        'status',
        'quantity',
        'image',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia')->where('quantity', '>', 0);
    }

    public function scopeBorrowed($query)
    {
        return $query->where('status', 'dipinjam');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'tersedia' && $this->quantity > 0;
    }

    public function getAvailableQuantity()
    {
        $borrowed = $this->loans()
            ->whereIn('status', ['pending', 'approved'])
            ->sum('quantity');
        
        return $this->quantity - $borrowed;
    }
}
