<?php

namespace App\Models;

use App\Models\{Permission, PermissionRole};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name',
        'role_slug',
        'role_desc',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permission_roles()
    {
        return $this->hasMany(PermissionRole::class);
    }
}
