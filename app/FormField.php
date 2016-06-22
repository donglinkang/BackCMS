<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use SoftDeletes;

    //

    public function getPluginAttribute($value)
    {
        return explode( '/', $value )[ 1 ];
    }
}
