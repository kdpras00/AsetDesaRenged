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
        // Default behavior: check availability for TODAY
        return $this->getAvailableStockForDateRange(now(), now());
    }

    /**
     * Get available stock for a specific date range.
     * Calculates the maximum usage on any single day within the range.
     */
    public function getAvailableStockForDateRange($startDate, $endDate, $excludeLoanId = null)
    {
        // We need to find the "worst case" day in this range where stock is lowest.
        // However, simplistic "sum of all overlaps" is a safe approximation for "worst case"
        // provided we don't assume loans overlap *each other* perfectly.
        // But the most robust way is to query strict overlaps.

        // Logic:
        // A loan overlaps if: loan.start <= request.end AND loan.end >= request.start
        
        $borrowedQuantity = $this->loans()
            ->whereIn('status', ['pending', 'approved', 'returning']) // returning items are still out
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('loan_date', '<=', $endDate)
                      ->where('return_date', '>=', $startDate);
            })
            ->when($excludeLoanId, function($q) use ($excludeLoanId) {
                $q->where('id', '!=', $excludeLoanId);
            })
            ->sum('quantity'); // This is a rough sum. Ideally we'd scan day-by-day but for low traffic this is "safe" (pessimistic).
            
        // Wait, 'sum' sums ALL overlapping loans. 
        // Example: 
        // Loan A: 1-10 Jan (Qty 5)
        // Loan B: 5-15 Jan (Qty 5)
        // Request: 1-15 Jan.
        // This query sums A+B = 10.
        // If Total = 10, then Available = 0.
        // This is correct because on Jan 5-10, usage IS 10.
        // So simple SUM of overlapping ranges is the correct "Max Usage" logic?
        // NO.
        // Example:
        // Loan A: 1-2 Jan.
        // Loan B: 20-22 Jan.
        // Request: 1-30 Jan.
        // Sum = Qty A + Qty B. But they never overlap each other!
        // So max usage for any single day is just Max(A, B).
        
        // Correct Algorithm for "Max Usage in Range":
        // Since SQL is hard to do "max concurrent usage", checking strict overlap for the *entire* requested period 
        // against the sum is a "Pessimistic / Safe" approach.
        // A sophisticated booking system checks day-by-day usage.
        
        // Given the scale (Village Asset Management), let's stick to the Safer Pessimistic check:
        // "If you want to book 1-30 Jan, any booking inside that month counts against your limit."
        // This prevents fragmentation but is much safer to implement.
        // However, the user complained about "Next Month" booking.
        // This simple overlap query SOLVES the "Next Month" issue perfectly.
        // It ONLY fails on "Long Duration Request spanning non-overlapping existing bookings" scenario.
        // Which is acceptable for this use case.

        return max(0, $this->quantity - $borrowedQuantity);
    }

    /**
     * Get dynamic rentable stock attribute.
     * Usage: $asset->rentable_stock
     */
    public function getRentableStockAttribute()
    {
        return $this->getAvailableQuantity();
    }
}
