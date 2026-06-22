import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp, router } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import '../css/app.css';

// Expõe Inertia globalmente para compatibilidade se necessário
window.Inertia = router;

// Wrap Ziggy's route function to inject active organ slug automatically
if (window.route) {
    const originalRoute = window.route;
    window.route = (name, params, absolute, config) => {
        if (!name) {
            return originalRoute(name, params, absolute, config);
        }

        let activeOrganSlug = router.page?.props?.active_organ?.slug;

        // Fallback 1: Parse from DOM dataset.page (vital on initial mount/first render)
        if (!activeOrganSlug) {
            try {
                const el = document.getElementById('app') || document.querySelector('[data-page]');
                if (el && el.dataset.page) {
                    const page = JSON.parse(el.dataset.page);
                    activeOrganSlug = page?.props?.active_organ?.slug;
                }
            } catch (e) {}
        }

        // Fallback 2: Parse from window.location.pathname
        if (!activeOrganSlug) {
            const firstSegment = window.location.pathname.split('/')[1];
            if (firstSegment && firstSegment !== 'login' && firstSegment !== 'register' && firstSegment !== 'dashboard') {
                activeOrganSlug = firstSegment;
            }
        }

        // Fallback 3: Hardcoded default 'gesem' as a safety net
        if (!activeOrganSlug) {
            activeOrganSlug = 'gesem';
        }

        const routeDef = window.Ziggy?.routes?.[name];

        if (routeDef && routeDef.uri && routeDef.uri.includes('{organ}')) {
            if (params === undefined || params === null) {
                params = { organ: activeOrganSlug };
            } else if (typeof params === 'object' && !Array.isArray(params)) {
                if (params.organ === undefined) {
                    params = { organ: activeOrganSlug, ...params };
                }
            } else if (Array.isArray(params)) {
                const matches = routeDef.uri.match(/\{[^}]+\}/g) || [];
                const paramCount = matches.length;
                if (params.length < paramCount) {
                    params = [activeOrganSlug, ...params];
                }
            } else {
                params = [activeOrganSlug, params];
            }
        }

        return originalRoute(name, params, absolute, config);
    };
}

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: '#7367f0',
        showSpinner: true,
    },
});


