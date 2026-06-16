<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Post;
use App\Models\Project;
use App\Models\Unit;

class SecretaryController extends Controller
{
    //

    public function web_index(){
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        return view('web.secretary.index', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries'));
    }
}
