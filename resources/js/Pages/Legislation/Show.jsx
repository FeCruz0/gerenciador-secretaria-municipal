import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LegislationShow({ legislation, categories, situations, authors, subjects, units }) {
    const [editing, setEditing] = useState(false);

    const { data, setData, put, processing, errors } = useForm({
        title: legislation.title || '',
        number: legislation.number || '',
        year: legislation.year || new Date().getFullYear(),
        ementa: legislation.ementa || legislation.content || '',
        category_id: legislation.category_id || '',
        situation_id: legislation.situation_id || '',
        author_id: legislation.author_id || '',
        unit_id: legislation.unit_id || '',
        status: legislation.status || 'DRAFT',
        date: legislation.date || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('legislacoes.update', legislation.id), { onSuccess: () => setEditing(false) });
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    const statusColors = {
        PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280',
    };
    const statusColor = statusColors[legislation.status] || '#6b7280';

    return (
        <AdminLayout title={`Legislação #${legislation.number || legislation.id}`}>
            <Head title={`Legislação: ${legislation.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 28 }}>
                <div>
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 4 }}>
                        <h1 style={{ fontSize: 22, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>{legislation.title}</h1>
                        <span style={{ background: statusColor + '20', color: statusColor, padding: '3px 12px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>
                            {legislation.status}
                        </span>
                    </div>
                    <p style={{ color: '#64748b', margin: 0 }}>Nº {legislation.number || '—'} · Ano {legislation.year || '—'}</p>
                </div>
                <div style={{ display: 'flex', gap: 10 }}>
                    <Link href={route('legislacoes.index')} style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
                    {!editing && (
                        <button onClick={() => setEditing(true)} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">Editar</button>
                    )}
                </div>
            </div>

            {!editing ? (
                <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 20 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em', marginTop: 0 }}>Ementa</h3>
                        <p style={{ color: '#f1f5f9', lineHeight: 1.7 }}>{legislation.ementa || legislation.content || 'Sem ementa cadastrada.'}</p>
                    </div>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em', marginTop: 0 }}>Detalhes</h3>
                        {[
                            ['Categoria', legislation.category?.category],
                            ['Situação', legislation.situation?.situation],
                            ['Data', legislation.date],
                        ].map(([label, value]) => (
                            <div key={label} style={{ marginBottom: 16 }}>
                                <p style={{ color: '#64748b', fontSize: 12, margin: '0 0 2px', textTransform: 'uppercase' }}>{label}</p>
                                <p style={{ color: '#f1f5f9', margin: 0 }}>{value || '—'}</p>
                            </div>
                        ))}
                        {legislation.subjects?.length > 0 && (
                            <div>
                                <p style={{ color: '#64748b', fontSize: 12, margin: '0 0 8px', textTransform: 'uppercase' }}>Assuntos</p>
                                <div style={{ display: 'flex', flexWrap: 'wrap', gap: 6 }}>
                                    {legislation.subjects.map(s => (
                                        <span key={s.id} style={{ background: '#334155', color: '#94a3b8', padding: '3px 10px', borderRadius: 20, fontSize: 12 }}>{s.subject}</span>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            ) : (
                <form onSubmit={handleSubmit}>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
                        <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Legislação</h3>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Título</label>
                                <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} />
                                {errors.title && <p style={errorStyle}>{errors.title}</p>}
                            </div>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Número</label>
                                    <input type="text" value={data.number} onChange={e => setData('number', e.target.value)} style={fieldStyle} />
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Ano</label>
                                    <input type="number" value={data.year} onChange={e => setData('year', e.target.value)} style={fieldStyle} />
                                </div>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Status</label>
                                <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                    <option value="DRAFT">Rascunho</option>
                                    <option value="PUBLISHED">Publicado</option>
                                    <option value="ARCHIVED">Arquivado</option>
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Ementa</label>
                                <textarea value={data.ementa} onChange={e => setData('ementa', e.target.value)} rows={6} style={{ ...fieldStyle, resize: 'vertical' }} />
                            </div>
                        </div>
                        <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Classificação</h3>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Categoria</label>
                                <select value={data.category_id} onChange={e => setData('category_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {categories.map(c => <option key={c.id} value={c.id}>{c.category}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Situação</label>
                                <select value={data.situation_id} onChange={e => setData('situation_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {situations.map(s => <option key={s.id} value={s.id}>{s.situation}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Data</label>
                                <input type="date" value={data.date} onChange={e => setData('date', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>
                    </div>
                    <div style={{ marginTop: 20, display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
                        <button type="button" onClick={() => setEditing(false)} style={{ padding: '10px 20px', borderRadius: 8, background: '#334155', color: '#94a3b8', border: 'none', cursor: 'pointer' }}>Cancelar</button>
                        <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: processing ? 0.6 : 1 }}>
                            {processing ? 'Salvando...' : 'Salvar alterações'}
                        </button>
                    </div>
                </form>
            )}
        </AdminLayout>
    );
}
