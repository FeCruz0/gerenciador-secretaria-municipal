import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function RevenueShow({ revenue, types }) {
    const [editing, setEditing] = useState(false);

    const { data, setData, put, processing } = useForm({
        title: revenue.title || '',
        description: revenue.description || '',
        value: revenue.value || '',
        type_id: revenue.type_id || '',
        competence: revenue.competence || '',
        status: revenue.status || 'DRAFT',
        reference: revenue.reference || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('receitas.update', revenue.id), { onSuccess: () => setEditing(false) });
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const groupStyle = { marginBottom: 20 };

    const statusColors = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280' };
    const statusColor = statusColors[revenue.status] || '#6b7280';

    return (
        <AdminLayout title={`Receita: ${revenue.title}`}>
            <Head title={`Receita: ${revenue.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 28 }}>
                <div>
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 4 }}>
                        <h1 style={{ fontSize: 22, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>{revenue.title}</h1>
                        <span style={{ background: statusColor + '20', color: statusColor, padding: '3px 12px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{revenue.status}</span>
                    </div>
                    <p style={{ color: '#10b981', margin: 0, fontSize: 18, fontWeight: 700 }}>
                        R$ {revenue.value ? Number(revenue.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '0,00'}
                    </p>
                </div>
                <div style={{ display: 'flex', gap: 10 }}>
                    <Link href={route('receitas.index')} style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
                    {!editing && <button onClick={() => setEditing(true)} className="btn-primary">Editar</button>}
                </div>
            </div>

            {!editing ? (
                <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 20 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 0 }}>Descrição</h3>
                        <p style={{ color: '#f1f5f9', lineHeight: 1.7 }}>{revenue.description || 'Sem descrição cadastrada.'}</p>
                        {revenue.files?.length > 0 && (
                            <>
                                <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 20 }}>Arquivos</h3>
                                {revenue.files.map(f => (
                                    <a key={f.id} href={f.url || '#'} target="_blank" rel="noopener noreferrer" style={{ display: 'block', color: '#7dd3fc', marginBottom: 4, fontSize: 14 }}>📎 {f.name || f.file_name}</a>
                                ))}
                            </>
                        )}
                    </div>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 0 }}>Detalhes</h3>
                        {[
                            ['Tipo', revenue.type?.title],
                            ['Competência', revenue.competence],
                            ['Referência', revenue.reference],
                            ['Cadastrado em', revenue.created_at ? new Date(revenue.created_at).toLocaleDateString('pt-BR') : null],
                        ].map(([label, value]) => (
                            <div key={label} style={{ marginBottom: 16 }}>
                                <p style={{ color: '#64748b', fontSize: 12, margin: '0 0 2px', textTransform: 'uppercase' }}>{label}</p>
                                <p style={{ color: '#f1f5f9', margin: 0 }}>{value || '—'}</p>
                            </div>
                        ))}
                    </div>
                </div>
            ) : (
                <form onSubmit={handleSubmit}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Receita</h3>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Título</label>
                                <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Tipo</label>
                                <select value={data.type_id} onChange={e => setData('type_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {types.map(t => <option key={t.id} value={t.id}>{t.title}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor</label>
                                <input type="number" step="0.01" value={data.value} onChange={e => setData('value', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Competência</label>
                                <input type="month" value={data.competence} onChange={e => setData('competence', e.target.value)} style={fieldStyle} />
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
                                <label style={labelStyle}>Referência</label>
                                <input type="text" value={data.reference} onChange={e => setData('reference', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={{ ...groupStyle, gridColumn: '1 / -1' }}>
                                <label style={labelStyle}>Descrição</label>
                                <textarea value={data.description} onChange={e => setData('description', e.target.value)} rows={4} style={{ ...fieldStyle, resize: 'vertical' }} />
                            </div>
                        </div>
                    </div>
                    <div style={{ marginTop: 20, display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
                        <button type="button" onClick={() => setEditing(false)} style={{ padding: '10px 20px', borderRadius: 8, background: '#334155', color: '#94a3b8', border: 'none', cursor: 'pointer' }}>Cancelar</button>
                        <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                            {processing ? 'Salvando...' : 'Salvar alterações'}
                        </button>
                    </div>
                </form>
            )}
        </AdminLayout>
    );
}
