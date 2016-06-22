<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use SoftDeletes;

    public function getArchiveField()
    {
        return $this->belongsTo( '\App\ArchiveField', 'archive_field_id' );
    }

//    public function getBodyAttribute( $value )
//    {
//        return json_decode($value);
//    }
}
