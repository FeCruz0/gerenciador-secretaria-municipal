import React from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { InertiaProgress } from '@inertiajs/progress';
import { Inertia } from '@inertiajs/inertia';

// Expõe Inertia globalmente para que links do Blade (sidebar/navbar)
// possam usar navegação SPA sem full page reload
window.Inertia = Inertia;

InertiaProgress.init({
    color: '#7367f0',
    showSpinner: true,
});

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => import(`./Pages/${name}`).then(module => module.default),
    setup({ el, App, props }) {
        render(<App {...props} />, el);
    },
});
