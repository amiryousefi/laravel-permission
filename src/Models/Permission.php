<?php

namespace Amir\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'action'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
