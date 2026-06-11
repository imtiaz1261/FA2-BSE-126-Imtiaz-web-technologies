<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'worker_id',
        'title',
        'category',
        'price',
        'rating',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'rating' => 'decimal:1',
        ];
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
