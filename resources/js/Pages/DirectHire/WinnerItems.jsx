import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function WinnerItems({ winner_selected, genres, matrial_statuses, countries, states, cities }) {
    const direct_hire = winner_selected.direct_hire;
    const person = winner_selected.person;

    // Itens que NÃO pertencem a esta pessoa (para vincular)
    const availableItems = direct_hire?.items?.filter(item => item.people_id !== person.id) || [];
    // Itens que pertencem a esta pessoa (para remover)
    const associatedItems = direct_hire?.items?.filter(item => item.people_id === person.id) || [];

    // Form para vincular itens
    const { data: addData, setData: setAddData, post: postAdd, processing: addProcessing } = useForm({
        items: []
    });

    // Form para remover itens
    const { data: removeData, setData: setRemoveData, post: postRemove, processing: removeProcessing } = useForm({
        remove_items: []
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        if (addData.items.length === 0) return;
        postAdd(route('winner_add_itens', person.id), {
            onSuccess: () => setAddData('items', [])
        });
    };

    const handleRemoveSubmit = (e) => {
        e.preventDefault();
        if (removeData.remove_items.length === 0) return;
        postRemove(route('winner_remove_itens'), {
            onSuccess: () => setRemoveData('remove_items', [])
        });
    };

    const handleSelectAddItems = (e) => {
        const options = e.target.options;
        const value = [];
        for (let i = 0, l = options.length; i < l; i++) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        setAddData('items', value);
    };

    const handleSelectRemoveItems = (e) => {
        const options = e.target.options;
        const value = [];
        for (let i = 0, l = options.length; i < l; i++) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        setRemoveData('remove_items', value);
    };

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };

    return (
        <AdminLayout title={`Itens do Vencedor - ${person.full_name}`}>
            <Head title={`Itens: ${person.full_name}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Vincular Itens ao Vencedor</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Contratação Direta: {direct_hire?.title || '—'}</p>
                </div>
                <Link href={route('contratacoes_diretas.show', direct_hire?.id)} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24, marginBottom: 24 }}>
                {/* Vincular Itens */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Disponíveis para Vincular</h3>
                    <form onSubmit={handleAddSubmit}>
                        <div style={{ marginBottom: 20 }}>
                            <label style={labelStyle}>Selecione um ou mais itens (Segure Ctrl para selecionar múltiplos)</label>
                            <select multiple value={addData.items} onChange={handleSelectAddItems} style={{ ...fieldStyle, height: 180 }}>
                                {availableItems.map(item => (
                                    <option key={item.id} value={item.id}>{item.name} - R$ {Number(item.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 })} (Qtd: {item.quantity})</option>
                                ))}
                            </select>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'flex-end' }}>
                            <button type="submit" disabled={addProcessing || addData.items.length === 0} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: (addProcessing || addData.items.length === 0) ? 0.6 : 1 }}>
                                Vincular Selecionados
                            </button>
                        </div>
                    </form>
                </div>

                {/* Remover Itens */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Itens já Vinculados</h3>
                    <form onSubmit={handleRemoveSubmit}>
                        <div style={{ marginBottom: 20 }}>
                            <label style={labelStyle}>Selecione um ou mais itens para remover (Segure Ctrl para selecionar múltiplos)</label>
                            <select multiple value={removeData.remove_items} onChange={handleSelectRemoveItems} style={{ ...fieldStyle, height: 180 }}>
                                {associatedItems.map(item => (
                                    <option key={item.id} value={item.id}>{item.name} - R$ {Number(item.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 })} (Qtd: {item.quantity})</option>
                                ))}
                            </select>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'flex-end' }}>
                            <button type="submit" disabled={removeProcessing || removeData.remove_items.length === 0} style={{ padding: '10px 24px', borderRadius: 8, background: '#7f1d1d', color: '#f87171', border: 'none', cursor: 'pointer', opacity: (removeProcessing || removeData.remove_items.length === 0) ? 0.6 : 1 }}>
                                Remover Selecionados
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {/* Listagem em formato de tabela */}
            <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Itens do Vencedor</h3>
                <div style={{ background: '#0f172a', borderRadius: 8, overflow: 'hidden', border: '1px solid #334155' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                        <thead>
                            <tr style={{ borderBottom: '1px solid #334155' }}>
                                {['Item', 'Quantidade', 'Custo Unitário (R$)', 'Total (R$)'].map(h => (
                                    <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {associatedItems.length === 0 ? (
                                <tr><td colSpan={4} style={{ padding: 24, textAlign: 'center', color: '#64748b' }}>Nenhum item vinculado a este vencedor ainda.</td></tr>
                            ) : (
                                associatedItems.map(item => (
                                    <tr key={item.id} style={{ borderBottom: '1px solid #1e293b' }}>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontSize: 13 }}>{item.name}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{item.quantity}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>R$ {Number(item.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                        <td style={{ padding: '12px 16px', color: '#10b981', fontWeight: 600, fontSize: 13 }}>R$ {(Number(item.value) * Number(item.quantity)).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
