<?php

namespace App\Models\Feature\Config;

use Illuminate\Database\Eloquent\Model;

class DashboardRoute extends Model
{
    protected $fillable = [
        'role_name',
        'route_name',
        'is_active',
    ];

}
