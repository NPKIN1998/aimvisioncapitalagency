<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'return',
        'capital',
        'days_paid',
        'next_payment',
        'date',
        'end_date',
    ];

    protected $casts = [
        'next_payment' => 'date',
        'date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
