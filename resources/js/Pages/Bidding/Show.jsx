import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function BiddingShow({ bidding, modalities, situations }) {
    const [editing, setEditing] = useState(false);

    const { data, setData, put, processing } = useForm({
        title: bidding.title || '',
        number: bidding.number || '',
        value: bidding.value || '',
        description: bidding.description || '',
        object: bidding.object || '',
        modality_id: bidding.modality_id || '',
        situation_id: bidding.situation_id || '',
        status: bidding.status || 'DRAFT',
        opening_date: bidding.opening_date || '',
        closing_date: bidding.closing_date || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('licitacoes.update', bidding.id), { onSuccess: () => setEditing(false) });
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const groupStyle = { marginBottom: 20 };

    const statusColors = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280', OPEN: '#3b82f6', CLOSED: '#ef4444' };
    const statusColor = statusColors[bidding.status] || '#6b7280';

    return (
        <AdminLayout title={`Licitação #${bidding.number || bidding.id}`}>
            <Head title={`Licitação: ${bidding.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 28 }}>
                <div>
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 4 }}>
                        <h1 style={{ fontSize: 22, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>{bidding.title}</h1>
                        <span style={{ background: statusColor + '20', color: statusColor, padding: '3px 12px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{bidding.status}</span>
                    </div>
                    <p style={{ color: '#64748b', margin: 0 }}>Nº {bidding.number || '—'} · Modalidade: {bidding.modality?.title || '—'}</p>
                </div>
                <div style={{ display: 'flex', gap: 10 }}>
                    <Link href={route('licitacoes.index')} style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
                    {!editing && <button onClick={() => setEditing(true)} className="btn-primary">Editar</button>}
                </div>
            </div>

            {!editing ? (
                <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 20 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 0 }}>Objeto</h3>
                        <p style={{ color: '#f1f5f9', lineHeight: 1.7 }}>{bidding.object || 'Não informado.'}</p>
                        {bidding.description && <>
                            <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 20 }}>Descrição</h3>
                            <p style={{ color: '#f1f5f9', lineHeight: 1.7 }}>{bidding.description}</p>
                        </>}
                    </div>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#94a3b8', fontSize: 13, fontWeight: 600, textTransform: 'uppercase', marginTop: 0 }}>Detalhes</h3>
                        {[
                            ['Valor', bidding.value ? 'R$ ' + Number(bidding.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : null],
                            ['Situação', bidding.situation?.title],
                            ['Abertura', bidding.opening_date],
                            ['Encerramento', bidding.closing_date],
                        ].map(([label, value]) => (
                            <div key={label} style={{ marginBottom: 16 }}>
                                <p style={{ color: '#64748b', fontSize: 12, margin: '0 0 2px', textTransform: 'uppercase' }}>{label}</p>
                                <p style={{ color: label === 'Valor' ? '#10b981' : '#f1f5f9', margin: 0, fontWeight: label === 'Valor' ? 700 : 400 }}>{value || '—'}</p>
                            </div>
                        ))}
                    </div>
                </div>
            ) : (
                <form onSubmit={handleSubmit}>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
                        <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Licitação</h3>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Título</label>
                                <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Número</label>
                                    <input type="text" value={data.number} onChange={e => setData('number', e.target.value)} style={fieldStyle} />
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Valor</label>
                                    <input type="number" step="0.01" value={data.value} onChange={e => setData('value', e.target.value)} style={fieldStyle} />
                                </div>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Objeto</label>
                                <textarea value={data.object} onChange={e => setData('object', e.target.value)} rows={3} style={{ ...fieldStyle, resize: 'vertical' }} />
                            </div>
                        </div>
                        <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Classificação</h3>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Modalidade</label>
                                <select value={data.modality_id} onChange={e => setData('modality_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {modalities.map(m => <option key={m.id} value={m.id}>{m.title}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Situação</label>
                                <select value={data.situation_id} onChange={e => setData('situation_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {situations.map(s => <option key={s.id} value={s.id}>{s.title}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Status</label>
                                <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                    <option value="DRAFT">Rascunho</option>
                                    <option value="PUBLISHED">Publicado</option>
                                    <option value="OPEN">Aberto</option>
                                    <option value="CLOSED">Encerrado</option>
                                    <option value="ARCHIVED">Arquivado</option>
                                </select>
                            </div>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Abertura</label>
                                    <input type="date" value={data.opening_date} onChange={e => setData('opening_date', e.target.value)} style={fieldStyle} />
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Encerramento</label>
                                    <input type="date" value={data.closing_date} onChange={e => setData('closing_date', e.target.value)} style={fieldStyle} />
                                </div>
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
