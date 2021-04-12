<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'token',
        'token_type',
        'token_status',
        'used_at',
        'expired_at',
        'user_id',
    ];
    
    protected $dates = [
        'used_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(Role::class, 'user_id', 'id');
    }
}
