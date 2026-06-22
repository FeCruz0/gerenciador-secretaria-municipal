import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import AdminLayout from '../../Components/Layout/AdminLayout';
import { 
    ArrowUp, 
    ArrowDown, 
    Eye, 
    EyeOff, 
    LayoutGrid, 
    Check, 
    Edit2,
    X,
    Sparkles
} from 'lucide-react';

export default function Index({ modules }) {
    const [localModules, setLocalModules] = useState([]);
    const [editingId, setEditingId] = useState(null);
    const [editTitle, setEditTitle] = useState('');

    useEffect(() => {
        if (modules) {
            setLocalModules([...modules].sort((a, b) => a.order - b.order));
        }
    }, [modules]);

    const handleToggle = (module) => {
        router.put(`/home_modulos/${module.id}`, {
            title: module.title,
            is_enabled: !module.is_enabled
        }, {
            preserveScroll: true,
        });
    };

    const startEditing = (module) => {
        setEditingId(module.id);
        setEditTitle(module.title);
    };

    const cancelEditing = () => {
        setEditingId(null);
        setEditTitle('');
    };

    const saveTitle = (module) => {
        if (!editTitle.trim()) return;
        router.put(`/home_modulos/${module.id}`, {
            title: editTitle,
            is_enabled: module.is_enabled
        }, {
            preserveScroll: true,
            onSuccess: () => cancelEditing(),
        });
    };

    const moveModule = (index, direction) => {
        const newModules = [...localModules];
        const targetIndex = direction === 'up' ? index - 1 : index + 1;

        if (targetIndex < 0 || targetIndex >= newModules.length) return;

        // Swap
        const temp = newModules[index];
        newModules[index] = newModules[targetIndex];
        newModules[targetIndex] = temp;

        // Re-assign orders
        const updatedModules = newModules.map((m, idx) => ({
            ...m,
            order: idx + 1
        }));

        setLocalModules(updatedModules);

        // Save order to backend
        router.put('/home_modulos/ordem', {
            modules: updatedModules.map(m => ({ id: m.id, order: m.order }))
        }, {
            preserveScroll: true,
        });
    };

    return (
        <AdminLayout title="Configuração da Home">
            <Head title="Módulos da Home" />

            <div className="space-y-6">
                {/* Header Section */}
                <div className="bg-gradient-to-r from-indigo-950 to-slate-900 border border-indigo-500/10 rounded-xl p-6 shadow-lg relative overflow-hidden">
                    <div className="absolute right-0 top-0 -mt-4 -mr-4 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
                    <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div className="flex items-center gap-2">
                                <Sparkles className="h-5 w-5 text-indigo-400" />
                                <h1 className="text-2xl font-bold text-slate-100">Módulos da Home Page</h1>
                            </div>
                            <p className="text-slate-400 mt-1 text-sm">
                                Organize, renomeie e defina a visibilidade das seções da página inicial do seu site.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Modules Manager Table/List */}
                <div className="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl">
                    <div className="p-4 border-b border-slate-800 bg-slate-900/60 flex items-center justify-between">
                        <div className="flex items-center gap-2 text-slate-300 font-semibold text-sm">
                            <LayoutGrid className="h-4 w-4 text-indigo-400" />
                            <span>Listagem de Componentes</span>
                        </div>
                    </div>

                    <div className="divide-y divide-slate-800">
                        {localModules.map((module, index) => (
                            <div 
                                key={module.id} 
                                className="p-4 md:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-950/40 transition-colors"
                            >
                                <div className="flex items-center gap-4 flex-1">
                                    {/* Order Buttons */}
                                    <div className="flex flex-col gap-1">
                                        <button
                                            onClick={() => moveModule(index, 'up')}
                                            disabled={index === 0}
                                            className={`p-1.5 rounded bg-slate-950 border border-slate-800 text-slate-400 hover:text-indigo-400 hover:border-indigo-500/30 transition-all ${
                                                index === 0 ? 'opacity-20 cursor-not-allowed' : 'cursor-pointer'
                                            }`}
                                            title="Mover para cima"
                                        >
                                            <ArrowUp className="h-3.5 w-3.5" />
                                        </button>
                                        <button
                                            onClick={() => moveModule(index, 'down')}
                                            disabled={index === localModules.length - 1}
                                            className={`p-1.5 rounded bg-slate-950 border border-slate-800 text-slate-400 hover:text-indigo-400 hover:border-indigo-500/30 transition-all ${
                                                index === localModules.length - 1 ? 'opacity-20 cursor-not-allowed' : 'cursor-pointer'
                                            }`}
                                            title="Mover para baixo"
                                        >
                                            <ArrowDown className="h-3.5 w-3.5" />
                                        </button>
                                    </div>

                                    {/* Module Info */}
                                    <div className="flex-1 min-w-0">
                                        {editingId === module.id ? (
                                            <div className="flex items-center gap-2 max-w-md">
                                                <input
                                                    type="text"
                                                    value={editTitle}
                                                    onChange={e => setEditTitle(e.target.value)}
                                                    className="bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-sm text-slate-100 focus:outline-none focus:border-indigo-500/50 w-full"
                                                    autoFocus
                                                />
                                                <button
                                                    onClick={() => saveTitle(module)}
                                                    className="p-2 bg-emerald-500/10 hover:bg-emerald-600 hover:text-white border border-emerald-500/20 text-emerald-400 rounded-lg transition-colors cursor-pointer"
                                                >
                                                    <Check className="h-4 w-4" />
                                                </button>
                                                <button
                                                    onClick={cancelEditing}
                                                    className="p-2 bg-rose-500/10 hover:bg-rose-600 hover:text-white border border-rose-500/20 text-rose-400 rounded-lg transition-colors cursor-pointer"
                                                >
                                                    <X className="h-4 w-4" />
                                                </button>
                                            </div>
                                        ) : (
                                            <div className="flex items-center gap-2">
                                                <h3 className="font-bold text-slate-100 truncate text-base">
                                                    {module.title}
                                                </h3>
                                                <button
                                                    onClick={() => startEditing(module)}
                                                    className="p-1 text-slate-500 hover:text-indigo-400 transition-colors cursor-pointer"
                                                    title="Editar título"
                                                >
                                                    <Edit2 className="h-3.5 w-3.5" />
                                                </button>
                                            </div>
                                        )}
                                        <p className="text-xs text-slate-500 mt-1 uppercase tracking-wider font-mono">
                                            tag: {module.name}
                                        </p>
                                    </div>
                                </div>

                                {/* Controls */}
                                <div className="flex items-center gap-3 self-end sm:self-auto">
                                    {/* Enable/Disable Toggle */}
                                    <button
                                        onClick={() => handleToggle(module)}
                                        className={`inline-flex items-center gap-2 px-4 py-2 rounded-lg border text-sm font-semibold transition-all cursor-pointer ${
                                            module.is_enabled 
                                            ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20' 
                                            : 'bg-slate-950 border-slate-800 text-slate-500 hover:bg-slate-900'
                                        }`}
                                    >
                                        {module.is_enabled ? (
                                            <>
                                                <Eye className="h-4 w-4" />
                                                <span>Ativo</span>
                                            </>
                                        ) : (
                                            <>
                                                <EyeOff className="h-4 w-4" />
                                                <span>Inativo</span>
                                            </>
                                        )}
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
