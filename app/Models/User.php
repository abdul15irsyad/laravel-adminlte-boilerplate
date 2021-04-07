<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $fillable = [
        'user_name',
        'user_username',
        'user_email',
        'user_new_email',
        'email_verified_at',
        'user_password',
    ];

    protected $hidden = [
        'user_password'
    ];

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
}
