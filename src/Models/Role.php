<?php

namespace Amir\Permission\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function scopeName(Builder $query, string $name)
    {
        $query->where('name', $name);
    }

    public function scopeNames(Builder $query, string $names)
    {
        $query->whereIn('name', $names);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
