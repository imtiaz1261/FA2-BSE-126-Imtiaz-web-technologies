<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerActivity extends Model
{
    protected $fillable = [
        'worker_id',
        'text',
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
