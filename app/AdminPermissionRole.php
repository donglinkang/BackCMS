<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionRole extends Model
{

    public function getAdminPermissionUser()
    {
        return $this->hasMany( '\App\AdminPermissionUser', 'admin_permission_role_id' );
    }

}
