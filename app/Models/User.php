<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'role',
        'status',
        'balance',
        'deposits',
        'investments',
        'country',
        'cashouts',
        'upline',
        'usercode',
        'password',
    ];

    protected $appended = ['upline_link'];

    public function upline(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upline', 'usercode');
    }

    public function downlines(): HasMany
    {
        return $this->hasMany(User::class, 'upline', 'usercode');
    }

    public function getUplineLinkAttribute()
    {
        return route('register', ['upline' => $this->usercode]);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Investment::class, 'user_id', 'id');
    }
}
