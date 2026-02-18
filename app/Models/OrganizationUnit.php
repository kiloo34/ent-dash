<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUnit extends Model
{
    use HasFactory;
    protected $table = 'app.organization_units';
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Get IDs of this unit and all its descendants recursively.
     * 
     * @return array<int>
     */
    public function getDescendantUnitIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getDescendantUnitIds());
        }

        return $ids;
    }
}   