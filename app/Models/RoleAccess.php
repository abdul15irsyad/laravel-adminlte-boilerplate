<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $fillable = [
        'role_id',
        'module_access_id',
    ];
}
