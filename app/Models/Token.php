<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'token',
        'token_type',
        'token_status',
        'expired_at',
        'user_id',
    ];
}
