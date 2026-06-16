<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Unit;
use Illuminate\Contracts\View\View;

class EntryReportsController extends Controller
{

    public function entry_index(): View
    {
        try{
            $unit = Unit::where('web', true)->first();
            $audits = Audit::orderBy('created_at', 'desc')->get();
            return view('admin.entryReport.index', compact('audits', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar as entradas!')->error();
            return redirect()->back()->withInput();
        }
    }
}
