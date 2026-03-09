<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralBonus extends Model
{
    protected $fillable = ['shortcode','user_id', 'downline', 'amount'];
}
