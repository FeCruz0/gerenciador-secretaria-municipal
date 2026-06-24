import React, { useState } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../Components/Layout/AdminLayout';
import { ArrowLeft, Save, Shield, ChevronDown, ChevronUp } from 'lucide-react';

export default function Create({ permissionsGrouped }) {
    const { active_organ } = usePage().props;
    const themeColor = active_organ?.theme_color_hex || '#6366f1';

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        permissions: []
    });

    const [openGroups, setOpenGroups] = useState(
        Object.keys(permissionsGrouped).reduce((acc, key) => {
            acc[key] = true; // start with all open
            return acc;
        }, {})
    );

    const toggleGroup = (groupName) => {
        setOpenGroups(prev => ({
            ...prev,
            [groupName]: !prev[groupName]
        }));
    };

    const handlePermissionChange = (permName) => {
        const isAlreadySelected = data.permissions.includes(permName);
        let updatedPermissions = [];

        if (isAlreadySelected) {
            updatedPermissions = data.permissions.filter(p => p !== permName);
        } else {
            updatedPermissions = [...data.permissions, permName];
        }

        setData('permissions', updatedPermissions);
    };

    const handleToggleAllGroup = (groupName, permsInGroup) => {
        const permNames = permsInGroup.map(p => p.name);
        const allSelected = permNames.every(name => data.permissions.includes(name));

        let updatedPermissions = [];
        if (allSelected) {
            // Uncheck all in this group
            updatedPermissions = data.permissions.filter(p => !permNames.includes(p));
        } else {
            // Check all in this group, avoiding duplicates
            const otherPermissions = data.permissions.filter(p => !permNames.includes(p));
            updatedPermissions = [...otherPermissions, ...permNames];
        }

        setData('permissions', updatedPermissions);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('roles.store'));
    };

    return (
        <AdminLayout title="Cadastrar Nova Regra / Perfil">
            <Head title="Nova Regra" />

            <div className="max-w-4xl mx-auto space-y-6">
                {/* Navigation Header */}
                <div className="flex items-center justify-between">
                    <Link
                        href={route('roles.index')}
                        className="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-slate-100 transition-colors"
                    >
                        <ArrowLeft className="h-4 w-4" />
                        Voltar para a Listagem
                    </Link>
                </div>

                {/* Form Card */}
                <div className="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl p-6 sm:p-8">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        
                        {/* Section: Basic Information */}
                        <div className="space-y-4">
                            <h3 className="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800 pb-2">
                                Informações do Perfil
                            </h3>
                            
                            <div className="space-y-1">
                                <label className="text-xs font-semibold text-slate-400">Nome da Regra / Perfil</label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={e => setData('name', e.target.value)}
                                    placeholder="Ex: Operador de Notícias, Administrador de Licitações..."
                                    className="w-full max-w-md px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                                    required
                                />
                                {errors.name && <p className="text-xs text-red-500">{errors.name}</p>}
                            </div>
                        </div>

                        {/* Section: Permissions Selection */}
                        <div className="space-y-4">
                            <div className="flex items-center justify-between border-b border-slate-800 pb-2">
                                <h3 className="text-sm font-bold text-slate-400 uppercase tracking-wider">
                                    Definição de Permissões
                                </h3>
                                <span className="text-xs font-semibold text-slate-400 bg-slate-850 px-2.5 py-1 rounded-md border border-slate-800">
                                    {data.permissions.length} selecionadas
                                </span>
                            </div>

                            {errors.permissions && <p className="text-xs text-red-500">{errors.permissions}</p>}

                            <div className="space-y-4">
                                {Object.entries(permissionsGrouped).map(([groupName, perms]) => {
                                    const groupPermNames = perms.map(p => p.name);
                                    const allSelectedInGroup = groupPermNames.every(name => data.permissions.includes(name));
                                    const isOpen = openGroups[groupName];

                                    return (
                                        <div key={groupName} className="border border-slate-800/80 rounded-xl overflow-hidden bg-slate-950/40">
                                            {/* Group Header */}
                                            <div 
                                                className="flex items-center justify-between px-4 py-3 bg-slate-950/80 border-b border-slate-800/50 cursor-pointer select-none"
                                                onClick={() => toggleGroup(groupName)}
                                            >
                                                <div className="flex items-center gap-2">
                                                    <span className="font-semibold text-sm text-slate-200">{groupName}</span>
                                                    <span className="text-[10px] bg-slate-800 text-slate-400 px-1.5 py-0.5 rounded font-medium">
                                                        {perms.length} permissões
                                                    </span>
                                                </div>

                                                <div className="flex items-center gap-4" onClick={e => e.stopPropagation()}>
                                                    <button
                                                        type="button"
                                                        onClick={() => handleToggleAllGroup(groupName, perms)}
                                                        className={`text-xs font-semibold px-2 py-0.5 rounded border transition-all ${
                                                            allSelectedInGroup 
                                                                ? 'bg-indigo-500/10 border-indigo-500/30 text-indigo-400 hover:bg-indigo-500/20' 
                                                                : 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700'
                                                        }`}
                                                    >
                                                        {allSelectedInGroup ? 'Desmarcar Todos' : 'Marcar Todos'}
                                                    </button>
                                                    
                                                    <button 
                                                        type="button" 
                                                        onClick={() => toggleGroup(groupName)}
                                                        className="text-slate-400 hover:text-slate-200"
                                                    >
                                                        {isOpen ? <ChevronUp className="h-4 w-4" /> : <ChevronDown className="h-4 w-4" />}
                                                    </button>
                                                </div>
                                            </div>

                                            {/* Group Checkboxes */}
                                            {isOpen && (
                                                <div className="p-4 grid grid-cols-1 md:grid-cols-2 gap-3 bg-slate-900/10">
                                                    {perms.map(perm => {
                                                        const isChecked = data.permissions.includes(perm.name);
                                                        return (
                                                            <label 
                                                                key={perm.id} 
                                                                className={`flex items-start gap-3 p-3 border rounded-lg cursor-pointer transition-all select-none hover:border-slate-700 ${
                                                                    isChecked 
                                                                        ? 'bg-indigo-500/5 border-indigo-500/40 text-indigo-200' 
                                                                        : 'bg-slate-950/40 border-slate-800/80 text-slate-400'
                                                                }`}
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    checked={isChecked}
                                                                    onChange={() => handlePermissionChange(perm.name)}
                                                                    className="mt-0.5 rounded border-slate-800 bg-slate-950 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0"
                                                                />
                                                                <div className="space-y-0.5">
                                                                    <span className="font-semibold text-xs block text-slate-200">{perm.name}</span>
                                                                    {perm.description && (
                                                                        <span className="text-[10px] text-slate-500 block leading-normal">{perm.description}</span>
                                                                    )}
                                                                </div>
                                                            </label>
                                                        );
                                                    })}
                                                </div>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </div>

                        {/* Submit Button */}
                        <div className="flex items-center justify-end border-t border-slate-800 pt-4">
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-sm font-bold text-white transition-all shadow-md active:scale-95 disabled:opacity-50"
                                style={{ backgroundColor: themeColor }}
                            >
                                <Save className="h-4.5 w-4.5" />
                                Salvar Regra
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
