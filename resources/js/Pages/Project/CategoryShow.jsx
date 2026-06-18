import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function CategoryShow({ category_selected, categories }) {
    const { data, setData, put, processing, errors } = useForm({
        title: category_selected.title || '',
        description: category_selected.description || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('projeto_categorias.update', category_selected.id));
    }

    function handleDelete() {
        if (confirm('Tem certeza que deseja excluir esta categoria?')) {
            Inertia.delete(route('projeto_categorias.destroy', category_selected.id));
        }
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
        <AdminLayout title="Editar Categoria">
            <Head title={`Editar Categoria - ${category_selected.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Dados da Categoria</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{category_selected.title}</p>
                </div>
                <Link href={route('projeto_categorias.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: 24 }}>
                {/* Editar Categoria */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', height: 'fit-content' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Cadastro</h3>
                    
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

                        <div style={{ display: 'flex', gap: 12 }}>
                            <button 
                                type="submit" 
                                disabled={processing} 
                                className="btn-primary" 
                                style={{ flex: 1, opacity: processing ? 0.6 : 1 }}
                            >
                                {processing ? 'Salvando...' : 'Editar'}
                            </button>
                            <button 
                                type="button"
                                onClick={handleDelete}
                                style={{ padding: '10px 18px', borderRadius: 8, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 14 }}
                            >
                                Deletar
                            </button>
                        </div>
                    </form>
                </div>

                {/* Listagem Geral (Visualização Rápida) */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginBottom: 20 }}>Todas as Categorias</h3>

                    <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155' }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Categoria</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Descrição</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {categories.map(c => (
                                    <tr 
                                        key={c.id} 
                                        style={{ 
                                            borderBottom: '1px solid #334155',
                                            background: c.id === category_selected.id ? '#0f172a' : 'transparent' 
                                        }}
                                    >
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: c.id === category_selected.id ? 700 : 500 }}>{c.title}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{c.description || '—'}</td>
                                        <td style={{ padding: '12px 16px', textAlign: 'right' }}>
                                            <Link 
                                                href={route('projeto_categorias.show', c.id)} 
                                                style={{ padding: '4px 10px', borderRadius: 6, background: '#334155', color: '#f1f5f9', fontSize: 12, textDecoration: 'none', display: 'inline-block' }}
                                            >
                                                Ver
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
