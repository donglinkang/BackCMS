<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormController extends Controller
{

    public function anyPlugin( $name )
    {
        \Plugins::register( $name, '\\App\\Plugins\\' . ucfirst( $name ) . '\\' . ucfirst( $name ) );

        return \Plugins::call( $name, [ $name ] );
    }

}
