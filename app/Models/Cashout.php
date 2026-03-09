<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'phone',
        'method',
        'Charge',
        'username',
        'status'
    ];
}
