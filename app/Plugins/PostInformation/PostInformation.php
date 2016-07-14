<?php
namespace App\Plugins\Authorize;

use App\Http\Requests\Request;

class Authorize
{

    public function run( $name = null )
    {
        $type = Request()->input( 'type' );

    }


}