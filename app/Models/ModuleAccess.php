<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAccess extends Model
{
    protected $fillable = [
        'module_id',
        'module_access_name',
        'module_access_slug',
    ];
}
