<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use App\Models\ShortcutWeb;
use App\Models\Unit;
use Illuminate\Http\Request;

class HomeWebController extends Controller
{

    public function index()
    {
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $web_shortcuts = ShortcutWeb::orderBy('order', 'asc')->get();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        return view('web.home.home', compact('posts', 'unit', 'web_shortcuts', 'news'));
    }

}
