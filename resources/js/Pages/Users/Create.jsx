import React, { useState } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../Components/Layout/AdminLayout';
import { ArrowLeft, Save, Eye, EyeOff, Shield, CheckCircle2 } from 'lucide-react';

export default function Create({ roles, organs }) {
    const { active_organ } = usePage().props;
    const themeColor = active_organ?.theme_color_hex || '#6366f1';

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        roles: [],
        organ_id: active_organ ? active_organ.id : '',
    });

    const [showPassword, setShowPassword] = useState(false);
    const [selectedRoleObject, setSelectedRoleObject] = useState(null);

    const handleRoleChange = (roleName) => {
        const isAlreadySelected = data.roles.includes(roleName);
        let updatedRoles = [];

        if (isAlreadySelected) {
            updatedRoles = data.roles.filter(r => r !== roleName);
        } else {
            updatedRoles = [...data.roles, roleName];
        }

        setData('roles', updatedRoles);

        // Find the last selected role object to show its permissions as preview
        if (updatedRoles.length > 0) {
            const lastRoleName = updatedRoles[updatedRoles.length - 1];
            const roleObj = roles.find(r => r.name === lastRoleName);
            setSelectedRoleObject(roleObj);
        } else {
            setSelectedRoleObject(null);
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('users.store'));
    };

    return (
        <AdminLayout title="Cadastrar Novo Usuário">
            <Head title="Novo Usuário" />

            <div className="max-w-4xl mx-auto space-y-6">
                {/* Navigation Header */}
                <div className="flex items-center justify-between">
                    <Link
                        href={route('users.index')}
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
                                Informações Básicas
                            </h3>
                            
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {/* Name */}
                                <div className="space-y-1">
                                    <label className="text-xs font-semibold text-slate-400">Nome Completo</label>
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={e => setData('name', e.target.value)}
                                        className="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                                        required
                                    />
                                    {errors.name && <p className="text-xs text-red-500">{errors.name}</p>}
                                </div>

                                {/* Email */}
                                <div className="space-y-1">
                                    <label className="text-xs font-semibold text-slate-400">Endereço de E-mail</label>
                                    <input
                                        type="email"
                                        value={data.email}
                                        onChange={e => setData('email', e.target.value)}
                                        className="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                                        required
                                    />
                                    {errors.email && <p className="text-xs text-red-500">{errors.email}</p>}
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {/* Password */}
                                <div className="space-y-1 relative">
                                    <label className="text-xs font-semibold text-slate-400">Senha de Acesso</label>
                                    <div className="relative">
                                        <input
                                            type={showPassword ? 'text' : 'password'}
                                            value={data.password}
                                            onChange={e => setData('password', e.target.value)}
                                            className="w-full pl-3 pr-10 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                                            required
                                        />
                                        <button
                                            type="button"
                                            onClick={() => setShowPassword(!showPassword)}
                                            className="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-300"
                                        >
                                            {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                        </button>
                                    </div>
                                    {errors.password && <p className="text-xs text-red-500">{errors.password}</p>}
                                </div>

                                {/* Organ Selection */}
                                <div className="space-y-1">
                                    <label className="text-xs font-semibold text-slate-400">Órgão / Setor Vinculado</label>
                                    {active_organ ? (
                                        <div className="px-3 py-2 bg-slate-800/50 border border-slate-800 rounded-lg text-slate-400 text-sm">
                                            {active_organ.sigla} - {active_organ.name}
                                        </div>
                                    ) : (
                                        <select
                                            value={data.organ_id}
                                            onChange={e => setData('organ_id', e.target.value)}
                                            className="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                                        >
                                            <option value="">Prefeitura / Instituição (Acesso Global)</option>
                                            {organs.map(org => (
                                                <option key={org.id} value={org.id}>
                                                    {org.sigla} - {org.name}
                                                </option>
                                            ))}
                                        </select>
                                    )}
                                    {errors.organ_id && <p className="text-xs text-red-500">{errors.organ_id}</p>}
                                </div>
                            </div>
                        </div>

                        {/* Section: Access Profiles (Roles) */}
                        <div className="space-y-4">
                            <h3 className="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800 pb-2">
                                Perfis de Acesso
                            </h3>
                            
                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                {roles.map(role => {
                                    const selected = data.roles.includes(role.name);
                                    return (
                                        <div 
                                            key={role.id}
                                            onClick={() => handleRoleChange(role.name)}
                                            className={`p-4 border rounded-xl cursor-pointer transition-all hover:scale-[1.02] flex items-start justify-between select-none ${
                                                selected 
                                                    ? 'bg-indigo-500/10 border-indigo-500 text-indigo-300' 
                                                    : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700'
                                            }`}
                                        >
                                            <div className="space-y-1">
                                                <div className="font-semibold text-sm text-slate-200">{role.name}</div>
                                                <div className="text-xs text-slate-500">
                                                    {role.permissions?.length || 0} permissões
                                                </div>
                                            </div>
                                            <Shield 
                                                className={`h-4 w-4 shrink-0 mt-0.5 ${selected ? 'text-indigo-400' : 'text-slate-700'}`} 
                                            />
                                        </div>
                                    );
                                })}
                            </div>
                            {errors.roles && <p className="text-xs text-red-500">{errors.roles}</p>}

                            {/* Dynamic Permissions Preview */}
                            {selectedRoleObject && (
                                <div className="mt-4 p-5 bg-slate-950 border border-slate-800 rounded-xl space-y-3">
                                    <h4 className="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                                        <Shield className="h-4 w-4 text-indigo-400" />
                                        Permissões incluídas no perfil: <span className="text-indigo-400 normal-case">{selectedRoleObject.name}</span>
                                    </h4>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-400 max-h-48 overflow-y-auto pr-2">
                                        {selectedRoleObject.permissions && selectedRoleObject.permissions.length > 0 ? (
                                            selectedRoleObject.permissions.map(perm => (
                                                <div key={perm.id} className="flex items-center gap-2">
                                                    <CheckCircle2 className="h-3.5 w-3.5 text-emerald-500 shrink-0" />
                                                    <span>{perm.name}</span>
                                                </div>
                                            ))
                                        ) : (
                                            <span className="text-slate-600">Nenhuma permissão associada a este perfil.</span>
                                        )}
                                    </div>
                                </div>
                            )}
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
                                Salvar Usuário
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
