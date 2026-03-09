<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'status',
        'return',
        'capital',
        'days_paid',
        'next_payment',
        'date',
        'end_date',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
