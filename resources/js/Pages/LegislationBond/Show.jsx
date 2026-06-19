import React, { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ bond, legislations, unit }) {
    const { flash } = usePage().props;
    const [formData, setFormData] = useState({
        base_id: bond.base_id || '',
        vinculo_id: bond.vinculo_id || '',
        status: bond.status || '',
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        setFormData({
            base_id: bond.base_id || '',
            vinculo_id: bond.vinculo_id || '',
            status: bond.status || '',
        });
        setErrors({});
    }, [bond]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        Inertia.put(`/legislacao_vinculos/${bond.id}`, formData, {
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este Vínculo?')) {
            Inertia.delete(`/legislacao_vinculos/${id}`);
        }
    };

    return (
        <>
            <Head title={`Editar Vínculo - #${bond.id}`} />

            <div style={{ padding: '32px', maxWidth: '800px', margin: '0 auto' }}>
                {/* Flash Messages */}
                {flash && flash.message && (
                    <div style={{
                        padding: '12px 20px',
                        marginBottom: '20px',
                        borderRadius: '8px',
                        backgroundColor: flash.type === 'success' ? '#dcfce7' : '#fee2e2',
                        color: flash.type === 'success' ? '#166534' : '#991b1b',
                        border: `1px solid ${flash.type === 'success' ? '#bbf7d0' : '#fecaca'}`,
                    }}>
                        {flash.message}
                    </div>
                )}

                {/* Back Link */}
                <div style={{ marginBottom: '20px' }}>
                    <a href="/legislacoes" style={{
                        color: '#2563eb',
                        textDecoration: 'none',
                        fontWeight: 600,
                        fontSize: '0.9rem',
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '4px'
                    }}>
                        ← Voltar para Legislações
                    </a>
                </div>

                <form onSubmit={handleSubmit} style={{
                    backgroundColor: '#fff',
                    padding: '24px',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                }}>
                    <h2 style={{ fontSize: '1.4rem', fontWeight: 700, marginBottom: '24px', color: '#1e293b' }}>
                        🔗 Editar Vínculo de Legislação
                    </h2>

                    {/* Base Legislation Select */}
                    <div style={{ marginBottom: '16px' }}>
                        <label style={labelStyle}>Legislação Base *</label>
                        <select
                            value={formData.base_id}
                            onChange={e => setFormData({ ...formData, base_id: e.target.value })}
                            required
                            style={{
                                ...inputStyle,
                                borderColor: errors.base_id ? '#ef4444' : '#cbd5e1'
                            }}
                        >
                            <option value="">Selecione a Legislação Base</option>
                            {legislations.map((leg) => (
                                <option key={leg.id} value={leg.id}>
                                    Nº {leg.number} ({leg.category?.category || '—'}) - {leg.ementa ? leg.ementa.substring(0, 80) + '...' : ''}
                                </option>
                            ))}
                        </select>
                        {errors.base_id && (
                            <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                {errors.base_id}
                            </span>
                        )}
                    </div>

                    {/* Vinculo Legislation Select */}
                    <div style={{ marginBottom: '16px' }}>
                        <label style={labelStyle}>Legislação Vinculada *</label>
                        <select
                            value={formData.vinculo_id}
                            onChange={e => setFormData({ ...formData, vinculo_id: e.target.value })}
                            required
                            style={{
                                ...inputStyle,
                                borderColor: errors.vinculo_id ? '#ef4444' : '#cbd5e1'
                            }}
                        >
                            <option value="">Selecione a Legislação Vinculada</option>
                            {legislations.map((leg) => (
                                <option key={leg.id} value={leg.id}>
                                    Nº {leg.number} ({leg.category?.category || '—'}) - {leg.ementa ? leg.ementa.substring(0, 80) + '...' : ''}
                                </option>
                            ))}
                        </select>
                        {errors.vinculo_id && (
                            <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                {errors.vinculo_id}
                            </span>
                        )}
                    </div>

                    {/* Status Field */}
                    <div style={{ marginBottom: '24px' }}>
                        <label style={labelStyle}>Status / Tipo de Vínculo *</label>
                        <input
                            type="text"
                            placeholder="Ex: Regulamentado por, Revogado por, etc."
                            value={formData.status}
                            onChange={e => setFormData({ ...formData, status: e.target.value })}
                            required
                            style={{
                                ...inputStyle,
                                borderColor: errors.status ? '#ef4444' : '#cbd5e1'
                            }}
                        />
                        {errors.status && (
                            <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                {errors.status}
                            </span>
                        )}
                    </div>

                    {/* Form Buttons */}
                    <div style={{ display: 'flex', gap: '12px' }}>
                        <button type="submit" style={{
                            flex: 1,
                            padding: '10px 16px',
                            backgroundColor: '#2563eb',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                            fontSize: '0.9rem',
                            textAlign: 'center',
                        }}>
                            Salvar Alterações
                        </button>
                        <button
                            type="button"
                            onClick={() => handleDelete(bond.id)}
                            style={{
                                padding: '10px 16px',
                                backgroundColor: '#ef4444',
                                color: '#fff',
                                border: 'none',
                                borderRadius: '8px',
                                cursor: 'pointer',
                                fontWeight: 600,
                                fontSize: '0.9rem',
                            }}
                        >
                            Excluir Vínculo
                        </button>
                    </div>
                </form>
            </div>
        </>
    );
}

const labelStyle = {
    display: 'block',
    fontSize: '0.85rem',
    fontWeight: 600,
    color: '#475569',
    marginBottom: '4px',
};

const inputStyle = {
    width: '100%',
    padding: '8px 12px',
    borderRadius: '6px',
    border: '1px solid #cbd5e1',
    fontSize: '0.9rem',
    outline: 'none',
    boxSizing: 'border-box',
};
