import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ gallery, unit }) {
    const { flash } = usePage().props;

    const [formData, setFormData] = useState({
        title: gallery.title || '',
        order: gallery.order || '',
        status: gallery.status || 'DRAFT',
        image_small: null,
        image_large: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = new FormData();
        data.append('_method', 'PUT');
        data.append('title', formData.title);
        data.append('order', formData.order || '');
        data.append('status', formData.status);

        if (formData.image_small) data.append('image_small', formData.image_small);
        if (formData.image_large) data.append('image_large', formData.image_large);

        Inertia.post(`/galeria_imagens/${gallery.id}`, data);
    };

    const statusOptions = [
        { value: 'DRAFT', label: 'Rascunho' },
        { value: 'PUBLISHED', label: 'Publicado' },
        { value: 'PENDING', label: 'Pendente' },
    ];

    return (
        <>
            <Head title={`Galeria - ${gallery.title}`} />

            <div style={{ padding: '32px', maxWidth: '960px', margin: '0 auto' }}>
                {/* Flash */}
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

                {/* Voltar */}
                <a
                    href="/galeria_imagens"
                    style={{
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '6px',
                        color: '#2563eb',
                        textDecoration: 'none',
                        fontWeight: 600,
                        marginBottom: '24px',
                        fontSize: '0.9rem',
                    }}
                >
                    ← Voltar para a Galeria
                </a>

                <h1 style={{ fontSize: '1.5rem', fontWeight: 700, color: '#1e293b', marginBottom: '24px' }}>
                    📸 {gallery.title}
                </h1>

                {/* Imagens atuais */}
                <div style={{
                    display: 'grid',
                    gridTemplateColumns: '1fr 1fr',
                    gap: '20px',
                    marginBottom: '32px',
                }}>
                    <div style={imageCard}>
                        <h3 style={imageLabelStyle}>Imagem Pequena</h3>
                        <div style={imageContainerStyle}>
                            <img
                                src={`/storage/gallery/${gallery.image_small}`}
                                alt="Miniatura"
                                style={{ maxWidth: '100%', maxHeight: '240px', objectFit: 'contain' }}
                                onError={(e) => { e.target.src = ''; e.target.alt = 'Imagem não encontrada'; }}
                            />
                        </div>
                        <p style={imagePathStyle}>{gallery.image_small}</p>
                    </div>
                    <div style={imageCard}>
                        <h3 style={imageLabelStyle}>Imagem Grande</h3>
                        <div style={imageContainerStyle}>
                            <img
                                src={`/storage/gallery/${gallery.image_large}`}
                                alt="Ampliada"
                                style={{ maxWidth: '100%', maxHeight: '240px', objectFit: 'contain' }}
                                onError={(e) => { e.target.src = ''; e.target.alt = 'Imagem não encontrada'; }}
                            />
                        </div>
                        <p style={imagePathStyle}>{gallery.image_large}</p>
                    </div>
                </div>

                {/* Info */}
                <div style={{
                    backgroundColor: '#f8fafc',
                    padding: '16px 20px',
                    borderRadius: '10px',
                    border: '1px solid #e2e8f0',
                    marginBottom: '32px',
                }}>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '16px' }}>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Status</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>{gallery.status}</p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Ordem</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>{gallery.order || '—'}</p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>ID</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>#{gallery.id}</p>
                        </div>
                    </div>
                </div>

                {/* Formulário de edição */}
                <div style={{
                    backgroundColor: '#fff',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    padding: '24px',
                }}>
                    <h2 style={{ fontSize: '1.1rem', fontWeight: 600, color: '#334155', marginBottom: '20px' }}>
                        ✏️ Editar Informações
                    </h2>
                    <form onSubmit={handleSubmit}>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '16px' }}>
                            <div>
                                <label style={labelStyle}>Título *</label>
                                <input
                                    type="text"
                                    value={formData.title}
                                    onChange={e => setFormData({ ...formData, title: e.target.value })}
                                    required
                                    style={inputStyle}
                                />
                            </div>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '12px' }}>
                                <div>
                                    <label style={labelStyle}>Ordem</label>
                                    <input
                                        type="number"
                                        value={formData.order}
                                        onChange={e => setFormData({ ...formData, order: e.target.value })}
                                        style={inputStyle}
                                    />
                                </div>
                                <div>
                                    <label style={labelStyle}>Status</label>
                                    <select
                                        value={formData.status}
                                        onChange={e => setFormData({ ...formData, status: e.target.value })}
                                        style={inputStyle}
                                    >
                                        {statusOptions.map(opt => (
                                            <option key={opt.value} value={opt.value}>{opt.label}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                            <div>
                                <label style={labelStyle}>Substituir Imagem Pequena</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_small: e.target.files[0] })}
                                    style={inputStyle}
                                />
                            </div>
                            <div>
                                <label style={labelStyle}>Substituir Imagem Grande</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_large: e.target.files[0] })}
                                    style={inputStyle}
                                />
                            </div>
                        </div>
                        <button type="submit" style={{
                            padding: '10px 28px',
                            backgroundColor: '#2563eb',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                        }}>
                            Salvar Alterações
                        </button>
                    </form>
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

const imageCard = {
    backgroundColor: '#f8fafc',
    borderRadius: '10px',
    border: '1px solid #e2e8f0',
    padding: '16px',
};

const imageLabelStyle = {
    fontSize: '0.9rem',
    fontWeight: 600,
    color: '#334155',
    marginBottom: '12px',
};

const imageContainerStyle = {
    width: '100%',
    minHeight: '160px',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#e2e8f0',
    borderRadius: '8px',
    marginBottom: '8px',
    overflow: 'hidden',
};

const imagePathStyle = {
    fontSize: '0.75rem',
    color: '#94a3b8',
    margin: 0,
    wordBreak: 'break-all',
};
