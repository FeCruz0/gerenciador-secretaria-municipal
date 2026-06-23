import React, { useState } from 'react';
import { Head, Link, usePage, router } from '@inertiajs/react';
import AdminLayout from '../../Components/Layout/AdminLayout';
import { Edit, Trash2, Plus, Search, Shield, Building2 } from 'lucide-react';

export default function Index({ users }) {
    const { flash, active_organ } = usePage().props;
    const [search, setSearch] = useState('');

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            router.delete(route('users.destroy', id));
        }
    };

    const filteredUsers = users.filter(user => 
        user.name?.toLowerCase().includes(search.toLowerCase()) ||
        user.email?.toLowerCase().includes(search.toLowerCase()) ||
        user.organ?.name?.toLowerCase().includes(search.toLowerCase()) ||
        user.organ?.sigla?.toLowerCase().includes(search.toLowerCase()) ||
        user.roles?.some(role => role.name?.toLowerCase().includes(search.toLowerCase()))
    );

    const themeColor = active_organ?.theme_color_hex || '#6366f1';

    return (
        <AdminLayout title="Gerenciamento de Usuários">
            <Head title="Usuários" />

            <div className="space-y-6">
                {/* Header Actions */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div className="relative flex-1 max-w-md">
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500">
                            <Search className="h-5 w-5" />
                        </span>
                        <input
                            type="text"
                            placeholder="Buscar por nome, email, órgão ou perfil..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                        />
                    </div>
                    
                    <Link
                        href={route('users.create')}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg active:scale-95"
                        style={{ backgroundColor: themeColor }}
                    >
                        <Plus className="h-4 w-4" />
                        Novo Usuário
                    </Link>
                </div>

                {/* Users Table */}
                <div className="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl">
                    {filteredUsers.length === 0 ? (
                        <div className="p-8 text-center text-slate-500">
                            Nenhum usuário encontrado com os termos pesquisados.
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-slate-800/40 border-b border-slate-800 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        <th className="px-6 py-4">Nome</th>
                                        <th className="px-6 py-4">E-mail</th>
                                        <th className="px-6 py-4">Órgão / Setor</th>
                                        <th className="px-6 py-4">Perfis</th>
                                        <th className="px-6 py-4 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-800/50">
                                    {filteredUsers.map((user) => (
                                        <tr key={user.id} className="hover:bg-slate-800/20 transition-colors">
                                            {/* Name & Avatar */}
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
                                                        {user.name ? user.name.slice(0, 2).toUpperCase() : 'US'}
                                                    </div>
                                                    <span className="font-semibold text-sm text-slate-200">{user.name}</span>
                                                </div>
                                            </td>

                                            {/* Email */}
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                                {user.email}
                                            </td>

                                            {/* Organ */}
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                {user.organ ? (
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                                        <Building2 className="h-3.5 w-3.5" />
                                                        {user.organ.sigla} - {user.organ.name}
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                                        Instituição (Prefeitura)
                                                    </span>
                                                )}
                                            </td>

                                            {/* Roles */}
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="flex flex-wrap gap-1">
                                                    {user.roles && user.roles.length > 0 ? (
                                                        user.roles.map((role) => (
                                                            <span 
                                                                key={role.id}
                                                                className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20"
                                                            >
                                                                <Shield className="h-3 w-3" />
                                                                {role.name}
                                                            </span>
                                                        ))
                                                    ) : (
                                                        <span className="text-xs text-slate-600">Nenhum</span>
                                                    )}
                                                </div>
                                            </td>

                                            {/* Actions */}
                                            <td className="px-6 py-4 whitespace-nowrap text-right">
                                                <div className="inline-flex items-center gap-2">
                                                    <Link
                                                        href={route('users.edit', user.id)}
                                                        className="p-1.5 rounded-lg text-slate-400 hover:text-amber-500 hover:bg-amber-500/10 border border-transparent hover:border-amber-500/20 transition-all"
                                                        title="Editar usuário"
                                                    >
                                                        <Edit className="h-4 w-4" />
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(user.id)}
                                                        className="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition-all"
                                                        title="Excluir usuário"
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
