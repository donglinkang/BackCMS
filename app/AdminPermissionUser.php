<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionUser extends Model
{
    public function getAdminPermission()
    {
        return $this->belongsTo( '\App\AdminPermission', 'admin_permission_id' );
    }

    public function getAdminPermissionRole()
    {
        return $this->belongsTo( '\App\AdminPermission', 'admin_permission_role_id' );
    }
}
