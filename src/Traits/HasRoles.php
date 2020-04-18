<?php

namespace amir\laravelpermission\Traits;

use amir\laravelpermission\Models\Role;

trait HasRoles
{
    public function role()
    {
        return $this->belongsTo(Role::class)->first();
    }
}
