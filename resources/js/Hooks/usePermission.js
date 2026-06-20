import { usePage } from '@inertiajs/react';

/**
 * Hook personalizado para checagem de permissões do usuário atual.
 */
export default function usePermission() {
    const { auth } = usePage().props;
    const permissions = auth?.permissions || [];

    /**
     * Verifica se o usuário possui uma permissão específica.
     * @param {string} permission 
     * @returns {boolean}
     */
    const hasPermission = (permission) => {
        return permissions.includes(permission);
    };

    /**
     * Verifica se o usuário possui pelo menos uma das permissões listadas.
     * @param {string[]} perms 
     * @returns {boolean}
     */
    const hasAnyPermission = (perms) => {
        return perms.some(p => permissions.includes(p));
    };

    return { permissions, hasPermission, hasAnyPermission };
}
