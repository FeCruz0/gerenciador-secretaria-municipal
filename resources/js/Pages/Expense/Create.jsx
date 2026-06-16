import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ExpenseCreate({ types }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        description: '',
        value: '',
        type_expense_id: '',
        competence: '',
        status: 'DRAFT',
        reference: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('despesas.store'), { onSuccess: () => reset() });
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
        <AdminLayout title="Nova Despesa">
            <Head title="Nova Despesa" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Nova Despesa</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Registre uma nova despesa no sistema</p>
                </div>
                <Link href={route('despesas.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 28, border: '1px solid #334155' }}>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Título *</label>
                            <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Tipo de Despesa</label>
                            <select value={data.type_expense_id} onChange={e => setData('type_expense_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {types.map(t => <option key={t.id} value={t.id}>{t.title}</option>)}
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Valor (R$) *</label>
                            <input type="number" step="0.01" min="0" value={data.value} onChange={e => setData('value', e.target.value)} style={fieldStyle} required />
                            {errors.value && <p style={errorStyle}>{errors.value}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Competência (mês/ano)</label>
                            <input type="month" value={data.competence} onChange={e => setData('competence', e.target.value)} style={fieldStyle} />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Referência / Documento</label>
                            <input type="text" value={data.reference} onChange={e => setData('reference', e.target.value)} style={fieldStyle} placeholder="Ex: NF-12345" />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status</label>
                            <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                <option value="DRAFT">Rascunho</option>
                                <option value="PUBLISHED">Publicado</option>
                                <option value="ARCHIVED">Arquivado</option>
                            </select>
                        </div>

                        <div style={{ ...groupStyle, gridColumn: '1 / -1' }}>
                            <label style={labelStyle}>Descrição</label>
                            <textarea value={data.description} onChange={e => setData('description', e.target.value)} rows={4} style={{ ...fieldStyle, resize: 'vertical' }} />
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('despesas.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Cancelar</Link>
                    <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Despesa'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
