<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Post;
use App\Models\Project;
use App\Models\Unit;

class InstitutionalWebController extends Controller{

    public function thesecretariat(){
        return view('web.institutional.thesecretariat');
    }

    public function organstructure(){
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        return view('web.institutional.organstructure', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries'));
       
    }

    public function managementreport(){
        return view('web.institutional.managementreport');
    }

    public function projects(){
        return view('web.institutional.projects');
    }

    public function conservationunits(){
        return view('web.institutional.conservationunits.home');
    }

    public function pecsol(){
        return view('web.institutional.conservationunits.pecsol');
    }
}
