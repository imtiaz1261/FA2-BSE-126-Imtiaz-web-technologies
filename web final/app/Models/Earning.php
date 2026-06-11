<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    protected $fillable = [
        'worker_id',
        'booking_id',
        'amount',
        'status',
        'earned_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'earned_date' => 'date',
        ];
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('earned_date', now()->month)
            ->whereYear('earned_date', now()->year);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
