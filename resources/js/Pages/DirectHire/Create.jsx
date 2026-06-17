import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function DirectHireCreate({ modalities, situations }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        status: 'DRAFT',
        modality_id: '',
        situation_id: '',
        bidding: '',
        value_min: '',
        value_max: '',
        local: '',
        content: '',
        process: '',
        published_at: '',
        realized_at: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('contratacoes_diretas.store'), { onSuccess: () => reset() });
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
        <AdminLayout title="Nova Contratação Direta">
            <Head title="Nova Contratação Direta" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Nova Contratação Direta</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Cadastre os dados da contratação direta</p>
                </div>
                <Link href={route('contratacoes_diretas.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Informações Gerais</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome / Título *</label>
                            <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Número da Contratação Direta</label>
                                <input type="text" value={data.bidding} onChange={e => setData('bidding', e.target.value)} style={fieldStyle} />
                                {errors.bidding && <p style={errorStyle}>{errors.bidding}</p>}
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Processo</label>
                                <input type="text" value={data.process} onChange={e => setData('process', e.target.value)} style={fieldStyle} />
                                {errors.process && <p style={errorStyle}>{errors.process}</p>}
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor Mínimo (R$)</label>
                                <input type="number" step="0.01" value={data.value_min} onChange={e => setData('value_min', e.target.value)} style={fieldStyle} />
                                {errors.value_min && <p style={errorStyle}>{errors.value_min}</p>}
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor Estimativa (R$)</label>
                                <input type="number" step="0.01" value={data.value_max} onChange={e => setData('value_max', e.target.value)} style={fieldStyle} />
                                {errors.value_max && <p style={errorStyle}>{errors.value_max}</p>}
                            </div>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Local</label>
                            <input type="text" value={data.local} onChange={e => setData('local', e.target.value)} style={fieldStyle} />
                            {errors.local && <p style={errorStyle}>{errors.local}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Objeto</label>
                            <textarea value={data.content} onChange={e => setData('content', e.target.value)} rows={4} style={{ ...fieldStyle, resize: 'vertical' }} />
                            {errors.content && <p style={errorStyle}>{errors.content}</p>}
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
                            {errors.modality_id && <p style={errorStyle}>{errors.modality_id}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Situação</label>
                            <select value={data.situation_id} onChange={e => setData('situation_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {situations.map(s => <option key={s.id} value={s.id}>{s.title}</option>)}
                            </select>
                            {errors.situation_id && <p style={errorStyle}>{errors.situation_id}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status</label>
                            <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                <option value="DRAFT">Desenvolvendo</option>
                                <option value="PENDING">Pendente</option>
                                <option value="PUBLISHED">Publicada</option>
                            </select>
                            {errors.status && <p style={errorStyle}>{errors.status}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data de Publicação do Edital</label>
                            <input type="date" value={data.published_at} onChange={e => setData('published_at', e.target.value)} style={fieldStyle} />
                            {errors.published_at && <p style={errorStyle}>{errors.published_at}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data da Licitação</label>
                            <input type="date" value={data.realized_at} onChange={e => setData('realized_at', e.target.value)} style={fieldStyle} />
                            {errors.realized_at && <p style={errorStyle}>{errors.realized_at}</p>}
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('contratacoes_diretas.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Cancelar</Link>
                    <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Contratação Direta'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
