<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Ponte de compatibilidade do Jetstream para tags legadas com prefixo x-jet-
        if (class_exists(\Laravel\Jetstream\Jetstream::class)) {
            \Illuminate\Support\Facades\Blade::component('components.form-section', 'jet-form-section');
            \Illuminate\Support\Facades\Blade::component('components.action-section', 'jet-action-section');
            \Illuminate\Support\Facades\Blade::component('components.section-title', 'jet-section-title');
            \Illuminate\Support\Facades\Blade::component('components.label', 'jet-label');
            \Illuminate\Support\Facades\Blade::component('components.input', 'jet-input');
            \Illuminate\Support\Facades\Blade::component('components.input-error', 'jet-input-error');
            \Illuminate\Support\Facades\Blade::component('components.action-message', 'jet-action-message');
            \Illuminate\Support\Facades\Blade::component('components.button', 'jet-button');
            \Illuminate\Support\Facades\Blade::component('components.section-border', 'jet-section-border');
            \Illuminate\Support\Facades\Blade::component('components.confirms-password', 'jet-confirms-password');
            \Illuminate\Support\Facades\Blade::component('components.modal', 'jet-modal');
            \Illuminate\Support\Facades\Blade::component('components.dialog-modal', 'jet-dialog-modal');
            \Illuminate\Support\Facades\Blade::component('components.danger-button', 'jet-danger-button');
            \Illuminate\Support\Facades\Blade::component('components.secondary-button', 'jet-secondary-button');
            \Illuminate\Support\Facades\Blade::component('components.checkbox', 'jet-checkbox');
            \Illuminate\Support\Facades\Blade::component('components.nav-link', 'jet-nav-link');
            \Illuminate\Support\Facades\Blade::component('components.responsive-nav-link', 'jet-responsive-nav-link');
            \Illuminate\Support\Facades\Blade::component('components.dropdown', 'jet-dropdown');
            \Illuminate\Support\Facades\Blade::component('components.dropdown-link', 'jet-dropdown-link');
            \Illuminate\Support\Facades\Blade::component('components.confirmation-modal', 'jet-confirmation-modal');
            \Illuminate\Support\Facades\Blade::component('components.validation-errors', 'jet-validation-errors');
        }
    }
}
