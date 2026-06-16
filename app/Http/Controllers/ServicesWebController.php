<?php

namespace App\Http\Controllers;

use App\Models\EnviromentalLicensing;
use App\Models\Unit;
use Illuminate\Http\Request;

class ServicesWebController extends Controller{

    public function environmentlicensing(){

        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentlicensing.home', compact('enviromental_licensing', 'unit' ));
    }

    public function postlicense(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentlicensing.postlicense', compact('enviromental_licensing', 'unit' ));
    }

    public function checklist(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentlicensing.checklist', compact('enviromental_licensing', 'unit' ));
    }

    public function forms(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentlicensing.forms', compact('enviromental_licensing', 'unit' ));
    }

    public function fiscalization(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.fiscalization', compact('enviromental_licensing', 'unit' ));
    }

    public function pruning(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.pruning', compact('enviromental_licensing', 'unit' ));
    }

    public function animalcause(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.animalcause', compact('enviromental_licensing', 'unit' ));
    }

    public function environmentprotection(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentprotection', compact('enviromental_licensing', 'unit' ));
    }

    public function environmentquality(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmentquality', compact('enviromental_licensing', 'unit' ));
    }

    public function environmenteducation(){
        $unit = Unit::where('web', true)->first();
        $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();
        return view('web.services.environmenteducation', compact('enviromental_licensing', 'unit' ));
    }
}
