<?php

namespace Amir\Permission\Models;


use Illuminate\Database\Eloquent\Model;


class PermissionRole extends Model
    {
        use HasFactory;
        public $timestamps = FALSE;
        public function role()
            {
                return $this->belongsTo(Role::class);
            }
        public function permission()
            {
               return $this->belongsTo(Permission::class) ;
            }
    }
