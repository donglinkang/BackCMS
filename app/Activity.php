<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use SoftDeletes;

    public function getUser( )
    {
        return $this->belongsTo('\App\Admin','admin_id')->withTrashed();
    }
}
