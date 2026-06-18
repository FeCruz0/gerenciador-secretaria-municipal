import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ProjectCreate({ categories }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        category_id: '',
        status: 'DRAFT',
        content: '',
        thumb: null,
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('projetos.store'), {
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
        <AdminLayout title="Novo Projeto">
            <Head title="Novo Projeto" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Novo Projeto</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Cadastre um novo projeto institucional</p>
                </div>
                <Link href={route('projetos.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 24 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Conteúdo do Projeto</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Título do Projeto *</label>
                            <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Descrição / Detalhes</label>
                            <textarea value={data.content} onChange={e => setData('content', e.target.value)} rows={10} style={{ ...fieldStyle, resize: 'vertical' }} />
                            {errors.content && <p style={errorStyle}>{errors.content}</p>}
                        </div>
                    </div>

                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Configuração</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Categoria *</label>
                            <select value={data.category_id} onChange={e => setData('category_id', e.target.value)} style={fieldStyle} required>
                                <option value="">Selecione uma Categoria...</option>
                                {categories.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                            </select>
                            {errors.category_id && <p style={errorStyle}>{errors.category_id}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status</label>
                            <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                <option value="DRAFT">Rascunho</option>
                                <option value="PENDING">Pendente</option>
                                <option value="PUBLISHED">Publicado</option>
                            </select>
                            {errors.status && <p style={errorStyle}>{errors.status}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Imagem de Capa (Thumb)</label>
                            <input type="file" onChange={e => setData('thumb', e.target.files[0])} style={fieldStyle} accept="image/*" />
                            {errors.thumb && <p style={errorStyle}>{errors.thumb}</p>}
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('projetos.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Cancelar</Link>
                    <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Projeto'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
