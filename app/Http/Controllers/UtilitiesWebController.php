<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilitiesWebController extends Controller{

    public function balneabilityofbeaches(){
        return view('web.utilities.balneabilityofbeaches');
    }
}