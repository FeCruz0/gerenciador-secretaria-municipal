<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Departament;
use Illuminate\Support\Facades\DB;

class FAQWebController extends Controller
{
    //
    public function index()
    {
        
        $faqs = Faq::where('status', 'PUBLISHED')->orderBy('question', 'asc')->get();
        $departaments = Departament::with('faqs')->get();
        return view('web.faq.index', compact('faqs','departaments'));
    }
}
