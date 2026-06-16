<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyEnvironmentWebController extends Controller{
    
    public function about(){
        return view('web.myenvironment.about');
    }

    public function publicpolicy(){
        return view('web.myenvironment.publicpolicy');
    }

    public function pillars(){
        return view('web.myenvironment.pillars');
    }
    
    public function campaign(){
        return view('web.myenvironment.campaign');
    }
}