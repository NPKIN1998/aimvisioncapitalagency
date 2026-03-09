<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    protected $fillable = [
        'user_id', // Add this line
        'package_id',
        'status',
        'capital',
        'days_paid',
        'next_payment',
        'date',
        'end_date',
        'return',
    ];

    protected $casts = [
        'next_payment' => 'datetime',
        'date' => 'datetime',
        'end_date' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
