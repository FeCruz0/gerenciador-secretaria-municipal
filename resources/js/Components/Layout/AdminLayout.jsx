import React from 'react';

/**
 * AdminLayout - wrapper transparente.
 * O layout completo (navbar, sidebar, footer, assets Vuexy)
 * já é carregado pelo app.blade.php, igual ao contentLayoutMaster.blade.php original.
 * Este componente apenas renderiza os filhos dentro da seção de conteúdo.
 */
export default function AdminLayout({ children }) {
    return (
        <section id="dashboard-analytics">
            {children}
        </section>
    );
}
