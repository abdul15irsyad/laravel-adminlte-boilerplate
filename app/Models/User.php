<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'user_name',
        'user_username',
        'user_email',
        'user_new_email',
        'email_verified_at',
        'user_password',
        'role_id',
    ];

    protected $hidden = [
        'user_password'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getUserStatusAttribute($value)
    {
        return $value == 'Y' ? "Active" : "Suspend";
    }

    // for Auth Laravel
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    // for sending email / notification Laravel
    public function routeNotificationForMail()
    {
        return $this->user_email;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
