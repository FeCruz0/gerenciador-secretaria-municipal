<?php

namespace App\Http\Middleware;

use App\Models\Organ;
use Closure;
use Illuminate\Http\Request;

class OrganContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Bypass if there are no organs configured in the database (e.g. during initial setup or tests)
        if (Organ::count() === 0) {
            \Illuminate\Support\Facades\URL::defaults(['organ' => 'gesem']);
            if ($request->route()) {
                $request->route()->forgetParameter('organ');
            }
            return $next($request);
        }

        $hasOrganParam = $request->route() && str_contains($request->route()->uri(), '{organ}');
        $defaultOrgan = Organ::where('is_active', true)->first();
        $defaultSlug = $defaultOrgan ? $defaultOrgan->slug : 'gesem';

        if ($hasOrganParam) {
            $slug = $request->route('organ');

            if (!$slug) {
                $slug = $defaultSlug;
            }

            $organ = Organ::where('slug', $slug)->where('is_active', true)->first();

            if (!$organ) {
                abort(404, 'Órgão não encontrado ou inativo.');
            }

            // Bind the active organ instance in the service container
            app()->instance('active_organ', $organ);

            // Set the default organ parameter for URL generation
            \Illuminate\Support\Facades\URL::defaults(['organ' => $slug]);

            // Remove the parameter so controllers don't need to declare it in their signatures
            $request->route()->forgetParameter('organ');
        } else {
            // Global/Institution route - active_organ is null (not bound)
            // Still set the default organ parameter for URL generation to prevent route helper crashes
            \Illuminate\Support\Facades\URL::defaults(['organ' => $defaultSlug]);
        }

        return $next($request);
    }
}
