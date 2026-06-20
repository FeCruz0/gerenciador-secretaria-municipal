import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function BiddingCreate({ modalities, situations }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        number: '',
        value: '',
        description: '',
        modality_id: '',
        situation_id: '',
        status: 'DRAFT',
        opening_date: '',
        closing_date: '',
        object: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('licitacoes.store'), { onSuccess: () => reset() });
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
        <AdminLayout title="Nova Licitação">
            <Head title="Nova Licitação" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Nova Licitação</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Cadastre os dados da licitação</p>
                </div>
                <Link href={route('licitacoes.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Informações Gerais</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Título *</label>
                            <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Número</label>
                                <input type="text" value={data.number} onChange={e => setData('number', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor (R$)</label>
                                <input type="number" step="0.01" value={data.value} onChange={e => setData('value', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Objeto</label>
                            <textarea value={data.object} onChange={e => setData('object', e.target.value)} rows={3} style={{ ...fieldStyle, resize: 'vertical' }} />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Descrição</label>
                            <textarea value={data.description} onChange={e => setData('description', e.target.value)} rows={4} style={{ ...fieldStyle, resize: 'vertical' }} />
                        </div>
                    </div>

                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Classificação e Datas</h3>

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

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data de Abertura</label>
                            <input type="date" value={data.opening_date} onChange={e => setData('opening_date', e.target.value)} style={fieldStyle} />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data de Encerramento</label>
                            <input type="date" value={data.closing_date} onChange={e => setData('closing_date', e.target.value)} style={fieldStyle} />
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('licitacoes.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Cancelar</Link>
                    <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Licitação'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
