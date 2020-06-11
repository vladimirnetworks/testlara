<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class listcontroller extends Controller
{
    //
    function list1() {
        return array("a"=>"ok");
    }


    function list2() {
       
        return Redirect::route('gaz');

    }
}
