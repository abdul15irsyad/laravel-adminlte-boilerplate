<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'permission_name',
        'permission_slug',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }

    public function permission_roles()
    {
        return $this->hasMany(PermissionRole::class);
    }
}

