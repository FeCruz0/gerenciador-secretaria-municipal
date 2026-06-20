import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function CategoryIndex({ categories }) {
    const [search, setSearch] = useState('');
    
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        description: '',
    });

    const filtered = categories.filter(c =>
        c.title?.toLowerCase().includes(search.toLowerCase())
    );

    function handleSubmit(e) {
        e.preventDefault();
        post(route('projeto_categorias.store'), {
            onSuccess: () => reset()
        });
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title="Categorias de Projetos">
            <Head title="Categorias de Projetos" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Categorias de Projetos</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{categories.length} categorias cadastradas</p>
                </div>
                <Link href={route('projetos.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar para Projetos</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: 24 }}>
                {/* Cadastrar Nova Categoria */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', height: 'fit-content' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Nova Categoria</h3>
                    
                    <form onSubmit={handleSubmit}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome da Categoria *</label>
                            <input 
                                type="text" 
                                value={data.title} 
                                onChange={e => setData('title', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Descrição *</label>
                            <textarea 
                                value={data.description} 
                                onChange={e => setData('description', e.target.value)} 
                                rows={4} 
                                style={{ ...fieldStyle, resize: 'vertical' }} 
                                required 
                            />
                            {errors.description && <p style={errorStyle}>{errors.description}</p>}
                        </div>

                        <button 
                            type="submit" 
                            disabled={processing} 
                            className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                            style={{ width: '100%', opacity: processing ? 0.6 : 1 }}
                        >
                            {processing ? 'Salvando...' : 'Salvar Categoria'}
                        </button>
                    </form>
                </div>

                {/* Listagem de Categorias */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, margin: 0 }}>Categorias Existentes</h3>
                        <input
                            type="text"
                            placeholder="Buscar categoria..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ padding: '6px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none', fontSize: 13, width: 200 }}
                        />
                    </div>

                    <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155' }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Categoria</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Descrição</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Registrado em</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.length === 0 ? (
                                    <tr><td colSpan={4} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma categoria encontrada</td></tr>
                                ) : filtered.map(c => (
                                    <tr key={c.id} style={{ borderBottom: '1px solid #334155' }}>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>{c.title}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{c.description || '—'}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>
                                            {c.created_at ? new Date(c.created_at).toLocaleDateString('pt-BR') : '—'}
                                        </td>
                                        <td style={{ padding: '12px 16px', textAlign: 'right' }}>
                                            <Link 
                                                href={route('projeto_categorias.show', c.id)} 
                                                style={{ padding: '4px 10px', borderRadius: 6, background: '#334155', color: '#f1f5f9', fontSize: 12, textDecoration: 'none', display: 'inline-block' }}
                                            >
                                                Editar
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
