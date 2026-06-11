<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'category',
        'experience',
        'hourly_rate',
        'address',
        'lat',
        'lng',
        'rating',
        'bio',
        'portfolio',
        'is_available',
        'total_jobs',
        'total_earnings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'portfolio' => 'array',
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
            'rating' => 'decimal:1',
            'hourly_rate' => 'decimal:2',
            'is_available' => 'boolean',
            'total_earnings' => 'decimal:2',
        ];
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'worker_id');
    }

    public function userBookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function workerBookings()
    {
        return $this->hasMany(Booking::class, 'worker_id');
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class, 'worker_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
