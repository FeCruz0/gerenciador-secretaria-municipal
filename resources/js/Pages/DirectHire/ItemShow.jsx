import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ItemShow({ item_selected, directHire }) {
    const { data, setData, put, processing, errors } = useForm({
        name: item_selected.name || '',
        quantity: item_selected.quantity || '',
        value: item_selected.value || '',
        people_id: item_selected.people_id || '',
        direct_hire_id: directHire.id,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('contratacao_direta_itens.update', item_selected.id));
    };

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title={`Editar Item - ${item_selected.name}`}>
            <Head title={`Editar Item: ${item_selected.name}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Editar Item</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Contratação Direta: {directHire.title}</p>
                </div>
                <Link href={route('contratacoes_diretas.show', directHire.id)} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit} style={{ maxWidth: 600 }}>
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <div style={groupStyle}>
                        <label style={labelStyle}>Descrição do Item *</label>
                        <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} style={fieldStyle} required />
                        {errors.name && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.name}</p>}
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Quantidade *</label>
                            <input type="number" value={data.quantity} onChange={e => setData('quantity', e.target.value)} style={fieldStyle} required />
                            {errors.quantity && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.quantity}</p>}
                        </div>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Custo Unitário (R$) *</label>
                            <input type="number" step="0.01" value={data.value} onChange={e => setData('value', e.target.value)} style={fieldStyle} required />
                            {errors.value && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.value}</p>}
                        </div>
                    </div>

                    <div style={groupStyle}>
                        <label style={labelStyle}>Vencedor Associado</label>
                        <select value={data.people_id} onChange={e => setData('people_id', e.target.value)} style={fieldStyle}>
                            <option value="">Selecione...</option>
                            {directHire.winners?.map(w => (
                                <option key={w.people_id} value={w.people_id}>{w.person?.full_name}</option>
                            ))}
                        </select>
                        {errors.people_id && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.people_id}</p>}
                    </div>

                    <div style={{ display: 'flex', justifyContent: 'flex-end', marginTop: 12 }}>
                        <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: processing ? 0.6 : 1 }}>
                            {processing ? 'Salvando...' : 'Salvar Alterações'}
                        </button>
                    </div>
                </div>
            </form>
        </AdminLayout>
    );
}
