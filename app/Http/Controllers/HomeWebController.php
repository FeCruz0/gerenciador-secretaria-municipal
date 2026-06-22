<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use App\Models\ShortcutWeb;
use App\Models\Unit;
use App\Models\HomeModule;
use Illuminate\Http\Request;

class HomeWebController extends Controller
{

    public function index()
    {
        $defaultOrgan = \App\Models\Organ::where('is_active', true)->first();
        $defaultOrganId = $defaultOrgan ? $defaultOrgan->id : null;

        $organId = app()->bound('active_organ') ? app('active_organ')->id : $defaultOrganId;

        $home_modules = HomeModule::withoutGlobalScope(\App\Scopes\OrganScope::class)
            ->where('is_enabled', true)
            ->where('organ_id', $organId)
            ->orderBy('order', 'asc')
            ->get();

        $posts = collect();
        $web_shortcuts = collect();
        $news = collect();

        foreach ($home_modules as $module) {
            if ($module->name === 'carousel_banners') {
                $posts = Post::withoutGlobalScope(\App\Scopes\OrganScope::class)
                    ->where('type_post_id', 1)
                    ->where('organ_id', $organId)
                    ->paginate(5)
                    ->load(['media']);
            } elseif ($module->name === 'shortcuts') {
                $web_shortcuts = ShortcutWeb::withoutGlobalScope(\App\Scopes\OrganScope::class)
                    ->where('organ_id', $organId)
                    ->orderBy('order', 'asc')
                    ->get();
            } elseif ($module->name === 'news') {
                $news = News::withoutGlobalScope(\App\Scopes\OrganScope::class)
                    ->where('status', 'PUBLISHED')
                    ->where('organ_id', $organId)
                    ->orderBy('id', 'desc')
                    ->paginate(3);
            }
        }

        $unit = Unit::where('web', true)->first();

        // Load all active organs for the "Secretarias e Autarquias" section on the Institution Home
        $organs = [];
        if (!app()->bound('active_organ')) {
            $organs = \App\Models\Organ::where('is_active', true)->get();
        }

        return view('web.home.home', compact('posts', 'unit', 'web_shortcuts', 'news', 'home_modules', 'organs'));
    }

}
