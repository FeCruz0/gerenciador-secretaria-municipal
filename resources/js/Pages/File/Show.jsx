import React, { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ file }) {
    const { flash } = usePage().props;
    const [formData, setFormData] = useState({
        title: file.title || '',
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        setFormData({
            title: file.title || '',
        });
        setErrors({});
    }, [file]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        Inertia.put(`/arquivos/${file.id}`, formData, {
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = () => {
        if (confirm('Tem certeza que deseja deletar este Arquivo?')) {
            Inertia.delete(`/arquivos/${file.id}`);
        }
    };

    // Gera a URL do asset para visualização
    const fileUrl = `/storage/files/${file.url}`;

    return (
        <>
            <Head title={`Visualizar Arquivo - ${file.title}`} />

            <div style={{ padding: '32px', maxWidth: '1000px', margin: '0 auto' }}>
                
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

                {/* Top Action Bar */}
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
                    <h1 style={{ fontSize: '1.5rem', fontWeight: 700, color: '#1e293b', margin: 0 }}>
                        📄 Gerenciador de Arquivo
                    </h1>
                    <button
                        onClick={() => window.history.back()}
                        style={{
                            padding: '8px 16px',
                            backgroundColor: '#64748b',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                            fontSize: '0.85rem',
                        }}
                    >
                        ← Voltar
                    </button>
                </div>

                {/* Edit Form & Info Card */}
                <div style={{
                    backgroundColor: '#fff',
                    padding: '24px',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                    marginBottom: '24px'
                }}>
                    <form onSubmit={handleSubmit}>
                        <div style={{ display: 'flex', gap: '16px', alignItems: 'flex-end', flexWrap: 'wrap' }}>
                            <div style={{ flex: 1, minWidth: '280px' }}>
                                <label style={labelStyle}>Nome / Título do Arquivo *</label>
                                <input
                                    type="text"
                                    value={formData.title}
                                    onChange={e => setFormData({ ...formData, title: e.target.value })}
                                    required
                                    style={{
                                        ...inputStyle,
                                        borderColor: errors.title ? '#ef4444' : '#cbd5e1'
                                    }}
                                />
                                {errors.title && (
                                    <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                        {errors.title}
                                    </span>
                                )}
                            </div>
                            
                            <div style={{ display: 'flex', gap: '12px' }}>
                                <button type="submit" style={{
                                    padding: '10px 24px',
                                    backgroundColor: '#2563eb',
                                    color: '#fff',
                                    border: 'none',
                                    borderRadius: '8px',
                                    cursor: 'pointer',
                                    fontWeight: 600,
                                    fontSize: '0.9rem',
                                }}>
                                    Salvar Título
                                </button>
                                <button
                                    type="button"
                                    onClick={handleDelete}
                                    style={{
                                        padding: '10px 24px',
                                        backgroundColor: '#ef4444',
                                        color: '#fff',
                                        border: 'none',
                                        borderRadius: '8px',
                                        cursor: 'pointer',
                                        fontWeight: 600,
                                        fontSize: '0.9rem',
                                    }}
                                >
                                    🗑 Deletar Arquivo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {/* PDF / File Viewer */}
                <div style={{
                    backgroundColor: '#fff',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    overflow: 'hidden',
                    boxShadow: '0 1px 3px rgba(0,0,0,0.02)'
                }}>
                    <div style={{
                        padding: '12px 20px',
                        backgroundColor: '#f8fafc',
                        borderBottom: '1px solid #e2e8f0',
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center'
                    }}>
                        <span style={{ fontSize: '0.9rem', fontWeight: 600, color: '#475569' }}>
                            Visualizador do Arquivo
                        </span>
                        <a
                            href={fileUrl}
                            target="_blank"
                            rel="noopener noreferrer"
                            style={{
                                fontSize: '0.85rem',
                                color: '#2563eb',
                                textDecoration: 'none',
                                fontWeight: 600
                            }}
                        >
                            ↗ Abrir em nova aba
                        </a>
                    </div>
                    
                    <div style={{ padding: '16px', backgroundColor: '#f1f5f9', display: 'flex', justifyContent: 'center' }}>
                        <iframe
                            src={fileUrl}
                            title={file.title}
                            style={{
                                width: '100%',
                                height: '650px',
                                border: 'none',
                                borderRadius: '8px',
                                backgroundColor: '#fff'
                            }}
                        />
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
    marginBottom: '6px',
};

const inputStyle = {
    width: '100%',
    padding: '10px 14px',
    borderRadius: '8px',
    border: '1px solid #cbd5e1',
    fontSize: '0.95rem',
    outline: 'none',
    boxSizing: 'border-box',
    boxShadow: 'inset 0 1px 2px rgba(0,0,0,0.02)'
};
