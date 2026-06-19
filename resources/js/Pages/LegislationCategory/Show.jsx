import React, { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ category_selected, legislation_categories, unit }) {
    const { flash } = usePage().props;
    const [formData, setFormData] = useState({
        category: category_selected.category || '',
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        setFormData({
            category: category_selected.category || '',
        });
        setErrors({});
    }, [category_selected]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        Inertia.put(`/legislacao_categorias/${category_selected.id}`, formData, {
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir esta Categoria?')) {
            Inertia.delete(`/legislacao_categorias/${id}`);
        }
    };

    return (
        <>
            <Head title={`Editar Categoria - ${category_selected.category}`} />

            <div style={{ padding: '32px', maxWidth: '1200px', margin: '0 auto' }}>
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

                {/* Breadcrumb / Back button */}
                <div style={{ marginBottom: '20px' }}>
                    <a href="/legislacao_categorias" style={{
                        color: '#2563eb',
                        textDecoration: 'none',
                        fontWeight: 600,
                        fontSize: '0.9rem',
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '4px'
                    }}>
                        ← Voltar para a Lista de Categorias
                    </a>
                </div>

                <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: '32px' }}>
                    
                    {/* Left Column: Form */}
                    <div>
                        <form onSubmit={handleSubmit} style={{
                            backgroundColor: '#fff',
                            padding: '24px',
                            borderRadius: '12px',
                            border: '1px solid #e2e8f0',
                            boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                        }}>
                            <h2 style={{ fontSize: '1.2rem', fontWeight: 700, marginBottom: '16px', color: '#1e293b' }}>
                                ✏️ Editar Categoria
                            </h2>

                            <div style={{ marginBottom: '20px' }}>
                                <label style={labelStyle}>Nome da Categoria *</label>
                                <input
                                    type="text"
                                    value={formData.category}
                                    onChange={e => setFormData({ ...formData, category: e.target.value })}
                                    required
                                    style={{
                                        ...inputStyle,
                                        borderColor: errors.category ? '#ef4444' : '#cbd5e1'
                                    }}
                                />
                                {errors.category && (
                                    <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                        {errors.category}
                                    </span>
                                )}
                            </div>

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
                                    Salvar
                                </button>
                                <button
                                    type="button"
                                    onClick={() => handleDelete(category_selected.id)}
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
                                    🗑 Excluir
                                </button>
                            </div>
                        </form>
                    </div>

                    {/* Right Column: Categories List */}
                    <div>
                        <div style={{
                            backgroundColor: '#fff',
                            borderRadius: '12px',
                            border: '1px solid #e2e8f0',
                            overflow: 'hidden',
                            boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                        }}>
                            <div style={{ backgroundColor: '#f8fafc', padding: '16px 24px', borderBottom: '1px solid #e2e8f0' }}>
                                <h3 style={{ margin: 0, fontSize: '1rem', fontWeight: 700, color: '#334155' }}>
                                    Categorias Cadastradas
                                </h3>
                            </div>
                            <div style={{ maxHeight: '500px', overflowY: 'auto' }}>
                                <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                                    <tbody>
                                        {legislation_categories.map((cat) => {
                                            const isSelected = cat.id === category_selected.id;
                                            return (
                                                <tr
                                                    key={cat.id}
                                                    style={{
                                                        borderBottom: '1px solid #f1f5f9',
                                                        backgroundColor: isSelected ? '#f1f5f9' : 'transparent',
                                                    }}
                                                >
                                                    <td style={{ ...tdStyle, padding: '12px 24px' }}>
                                                        <a
                                                            href={`/legislacao_categorias/${cat.id}`}
                                                            style={{
                                                                fontWeight: isSelected ? 700 : 500,
                                                                color: isSelected ? '#2563eb' : '#475569',
                                                                textDecoration: 'none',
                                                                display: 'block'
                                                            }}
                                                        >
                                                            {cat.category}
                                                            {isSelected && ' (Editando)'}
                                                        </a>
                                                    </td>
                                                    <td style={{ ...tdStyle, textAlign: 'right', padding: '12px 24px' }}>
                                                        <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>
                                                            {cat.created_at ? new Date(cat.created_at).toLocaleDateString('pt-BR') : '—'}
                                                        </span>
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
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

const tdStyle = {
    padding: '16px',
    fontSize: '0.9rem',
    verticalAlign: 'middle',
};
