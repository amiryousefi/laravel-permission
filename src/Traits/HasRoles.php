<?php

namespace Amir\Permission\Traits;

use Amir\Permission\Models\Role;

trait HasRoles
{
    public function role()
    {
        return $this->belongsTo(Role::class)->first();
    }
}
