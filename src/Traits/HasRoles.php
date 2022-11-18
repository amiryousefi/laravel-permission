<?php

namespace Amir\Permission\Traits;

use Amir\Permission\Models\Role;

trait HasRoles
{
    public function role()
        {
            return $this->belongsTo(Role::class);
        }
    
    public function getRoleNameAttribute()
        {
            return $this->role()->first()->name ?? null ;
        }
    public function permission()
        {
            return $this->hasManyThrough(Permission::class,Permission_Role::class,'role_id','id','role_id','permission_id');
        }
}
