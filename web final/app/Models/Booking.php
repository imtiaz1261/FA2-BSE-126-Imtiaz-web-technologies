<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'worker_id',
        'service_id',
        'date',
        'time',
        'notes',
        'customer_address',
        'customer_lat',
        'customer_lng',
        'customer_formatted_address',
        'status',
        'rejection_reason',
        'accepted_at',
        'completed_at',
        'rejected_at',
        'rating',
        'review',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'rating' => 'decimal:1',
            'accepted_at' => 'datetime',
            'completed_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function earning()
    {
        return $this->hasOne(Earning::class);
    }

    public function hasLocation(): bool
    {
        return ! empty($this->customer_lat) && ! empty($this->customer_lng);
    }

    public function getPriceAttribute(): float
    {
        return (float) ($this->service?->price ?? 0);
    }
}
