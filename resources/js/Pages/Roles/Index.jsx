import React, { useState } from 'react';
import { Head, Link, usePage, router } from '@inertiajs/react';
import AdminLayout from '../../Components/Layout/AdminLayout';
import { Edit, Trash2, Plus, Search, Shield, Users, CheckCircle } from 'lucide-react';

export default function Index({ roles }) {
    const { flash, active_organ } = usePage().props;
    const [search, setSearch] = useState('');

    const handleDelete = (role) => {
        if (role.users_count > 0) {
            alert('Não é possível excluir esta regra pois há usuários vinculados a ela!');
            return;
        }

        if (confirm(`Tem certeza que deseja excluir a regra "${role.name}"?`)) {
            router.delete(route('roles.destroy', role.id));
        }
    };

    const filteredRoles = roles.filter(role => 
        role.name?.toLowerCase().includes(search.toLowerCase()) ||
        role.permissions?.some(perm => perm.name?.toLowerCase().includes(search.toLowerCase()))
    );

    const themeColor = active_organ?.theme_color_hex || '#6366f1';

    return (
        <AdminLayout title="Gerenciamento de Regras e Perfis">
            <Head title="Regras de Acesso" />

            <div className="space-y-6">
                {/* Status Alerts */}
                {flash && flash.error && (
                    <div className="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm">
                        {flash.error}
                    </div>
                )}
                {flash && flash.success && (
                    <div className="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-400 text-sm">
                        {flash.success}
                    </div>
                )}

                {/* Header Actions */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div className="relative flex-1 max-w-md">
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500">
                            <Search className="h-5 w-5" />
                        </span>
                        <input
                            type="text"
                            placeholder="Buscar por nome do perfil ou permissão..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                        />
                    </div>
                    
                    <Link
                        href={route('roles.create')}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg active:scale-95"
                        style={{ backgroundColor: themeColor }}
                    >
                        <Plus className="h-4 w-4" />
                        Nova Regra / Perfil
                    </Link>
                </div>

                {/* Roles Table */}
                <div className="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl">
                    {filteredRoles.length === 0 ? (
                        <div className="p-8 text-center text-slate-500">
                            Nenhum perfil de acesso encontrado.
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-slate-800/40 border-b border-slate-800 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        <th className="px-6 py-4">Nome do Perfil</th>
                                        <th className="px-6 py-4">Usuários Vinculados</th>
                                        <th className="px-6 py-4">Permissões</th>
                                        <th className="px-6 py-4 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-800/50">
                                    {filteredRoles.map((role) => (
                                        <tr key={role.id} className="hover:bg-slate-800/20 transition-colors">
                                            {/* Role Name */}
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="flex items-center gap-3">
                                                    <div 
                                                        className="h-9 w-9 rounded-full flex items-center justify-center font-bold text-sm"
                                                        style={{ 
                                                            backgroundColor: `${themeColor}22`,
                                                            border: `1px solid ${themeColor}44`,
                                                            color: themeColor
                                                        }}
                                                    >
                                                        <Shield className="h-4 w-4" />
                                                    </div>
                                                    <span className="font-semibold text-sm text-slate-200">{role.name}</span>
                                                </div>
                                            </td>

                                            {/* Linked Users Count */}
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                                    <Users className="h-3.5 w-3.5" />
                                                    {role.users_count || 0} usuários
                                                </span>
                                            </td>

                                            {/* Permissions List summary */}
                                            <td className="px-6 py-4 max-w-xs md:max-w-md">
                                                <div className="flex flex-wrap gap-1">
                                                    {role.permissions && role.permissions.length > 0 ? (
                                                        role.permissions.slice(0, 5).map((perm) => (
                                                            <span 
                                                                key={perm.id}
                                                                className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-800 text-slate-300 border border-slate-700"
                                                            >
                                                                {perm.name}
                                                            </span>
                                                        ))
                                                    ) : (
                                                        <span className="text-xs text-slate-600">Nenhuma permissão</span>
                                                    )}
                                                    {role.permissions && role.permissions.length > 5 && (
                                                        <span className="text-[10px] text-slate-500 self-center font-semibold pl-1">
                                                            +{role.permissions.length - 5} mais
                                                        </span>
                                                    )}
                                                </div>
                                            </td>

                                            {/* Actions */}
                                            <td className="px-6 py-4 whitespace-nowrap text-right">
                                                <div className="inline-flex items-center gap-2">
                                                    <Link
                                                        href={route('roles.edit', role.id)}
                                                        className="p-1.5 rounded-lg text-slate-400 hover:text-amber-500 hover:bg-amber-500/10 border border-transparent hover:border-amber-500/20 transition-all"
                                                        title="Editar Regra"
                                                    >
                                                        <Edit className="h-4 w-4" />
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(role)}
                                                        className={`p-1.5 rounded-lg text-slate-400 border border-transparent transition-all ${
                                                            role.users_count > 0 
                                                                ? 'opacity-30 cursor-not-allowed' 
                                                                : 'hover:text-red-500 hover:bg-red-500/10 hover:border-red-500/20'
                                                        }`}
                                                        disabled={role.users_count > 0}
                                                        title={role.users_count > 0 ? "Esta regra tem usuários ativos" : "Excluir Regra"}
                                                    >
                                                        <Trash2 className="h-4 w-4" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
