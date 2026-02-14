<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'app.positions';

    protected $fillable = [
        'name',
        'level',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
