<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use App\Models\TypeRequest;
use App\Models\Unit;
use App\Services\NewsService;

class WebController extends Controller
{
    /**
     * Display home.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        protected NewsService $newsService,
    ){}

    public function __invoke()
    {
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        return view('web.home.home', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries'));

    }

    public function transparency_index()
    {
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(9);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        $type_requests = TypeRequest::all();
        return view('web.home.transparency', compact('news', 'unit', 'projects', 'leaderships', 'galleries', 'type_requests'));

    }

    public function contact()
    {
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(9);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        return view('web.home.contact', compact('news', 'unit', 'projects', 'leaderships', 'galleries'));

    }

    public function news_web_index()
    {
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $tags = Tag::all();
        $unit = Unit::where('web', true)->first();
        $categories = Category::all();
        $banner = Banner::where('banner_type_id', 4)->first();
        return view('web.news.index', compact('banner', 'news', 'tags', 'categories', 'unit', 'projects', 'leaderships', 'galleries'));
    }

    public function news_web_index_filter_title(Request $request)
    {
        $news = News::filter($request->all())->where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $tags = Tag::all();
        $unit = Unit::where('web', true)->first();
        $categories = Category::all();
        $banner = Banner::where('banner_type_id', 4)->first();
        return view('web.news.index', compact('banner', 'news', 'tags', 'categories', 'unit', 'projects', 'leaderships', 'galleries'));
    }

    public function news_web_index_filter_category($category_id)
    {
        $news = News::where('status', 'PUBLISHED')->where('category_id', $category_id)->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $tags = Tag::all();
        $unit = Unit::where('web', true)->first();
        $categories = Category::all();
        $banner = Banner::where('banner_type_id', 4)->first();
        return view('web.news.index', compact('banner', 'news', 'tags', 'categories', 'unit', 'projects', 'leaderships', 'galleries'));
    }

    public function news_web_index_filter_tag($tag_id)
    {
        $news = News::with('tags')->where('status', 'PUBLISHED')->where('tags->id', $tag_id)->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $tags = Tag::all();
        $unit = Unit::where('web', true)->first();
        $categories = Category::all();
        $banner = Banner::where('banner_type_id', 4)->first();
        return view('web.news.index', compact('banner', 'news', 'tags', 'categories', 'unit', 'projects', 'leaderships', 'galleries'));
    }

    public function news_web_show($new)
    {
        $new = News::find($new);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        $categories = Category::all();
        $tags = Tag::all();
        $posts = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(9);
        return view('web.news.show', compact('news', 'new', 'posts', 'unit', 'categories', 'tags', 'projects', 'leaderships', 'galleries'));
    }
}
