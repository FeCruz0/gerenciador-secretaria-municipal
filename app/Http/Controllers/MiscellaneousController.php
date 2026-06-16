<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class MiscellaneousController extends Controller
{
  // Coming Soon
  public function coming_soon()
  {
    $pageConfigs = ['blankPage' => true];
        
        $unit = Unit::where('web', true)->first();

    return view('/content/miscellaneous/page-coming-soon', ['pageConfigs' => $pageConfigs], compact('unit'));
  }

  // Error
  public function error()
  {
    $pageConfigs = ['blankPage' => true];
        
        $unit = Unit::where('web', true)->first();

    return view('/content/miscellaneous/error', ['pageConfigs' => $pageConfigs], compact('unit'));
  }

  // Not-authorized
  public function not_authorized()
  {
    $pageConfigs = ['blankPage' => true];
        
        $unit = Unit::where('web', true)->first();

    return view('/content/miscellaneous/page-not-authorized', ['pageConfigs' => $pageConfigs], compact('unit'));
  }

  // Maintenance
  public function maintenance()
  {
    $pageConfigs = ['blankPage' => true];
        
        $unit = Unit::where('web', true)->first();

    return view('/content/miscellaneous/page-maintenance', [
      'pageConfigs' => $pageConfigs
    ]);
  }
}
