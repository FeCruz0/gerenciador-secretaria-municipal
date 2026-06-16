<?php

namespace App\Http\Controllers;

use App\Models\Orderly;
use App\Models\Unit;
use Illuminate\Http\Request;

use Inertia\Inertia;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('admin/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboard()
  {
    $pageConfigs = ['pageHeader' => false];

    /*
    $orderlies = Orderly::all();
 
    $ordelies_today = Orderly::with(['ordelyTime', 'watchman'])
    ->whereDate('started_at', '=' , date('Y-m-d'))
    ->where('active', '=' , 1)
    ->orderBy('started_at', 'desc')
    ->get(); 

    $ordelies_confirmed = Orderly::with(['ordelyTime', 'watchman'])
    ->whereDate('started_at', '>=' , date('Y-m-d'))
    ->where('active', '=' , 1)
    ->orderBy('started_at', 'desc')
    ->get();
    */

    $unit = Unit::where('web', true)->first();
    return Inertia::render('Dashboard', [
        'unit' => $unit
    ]);
  }
}
