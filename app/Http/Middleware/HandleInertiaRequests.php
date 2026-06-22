<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Try to resolve active organ from route parameter if not already bound
        if (!app()->has('active_organ')) {
            $slug = $request->route('organ');
            if ($slug) {
                $organ = \App\Models\Organ::where('slug', $slug)->where('is_active', true)->first();
                if ($organ) {
                    app()->instance('active_organ', $organ);
                }
            }
        }

        $activeOrgan = app()->has('active_organ') ? app('active_organ') : null;

        return array_merge(parent::share($request), [
            'active_organ' => $activeOrgan ? [
                'id' => $activeOrgan->id,
                'name' => $activeOrgan->name,
                'sigla' => $activeOrgan->sigla,
                'slug' => $activeOrgan->slug,
                'theme_color_hex' => $activeOrgan->theme_color_hex,
                'logo_path' => $activeOrgan->logo_path,
            ] : null,
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'profile_photo_path' => $request->user()->profile_photo_path,
                    'occupation' => $request->user()->occupations->first()?->title ?? 'Desenvolvedor',
                ] : null,
                'permissions' => $request->user()
                    ? $request->user()->getAllPermissions()->pluck('name')->toArray()
                    : [],
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'errors' => fn () => $request->session()->get('errors')
                ? $request->session()->get('errors')->getBag('default')->getMessages()
                : (object) [],
        ]);
    }
}
