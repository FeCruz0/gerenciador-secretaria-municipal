import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ types, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [editingTypeId, setEditingTypeId] = useState(null);

    // Form state
    const [formData, setFormData] = useState({
        title: '',
        status: 'DRAFT',
        image: null,
    });

    const filteredTypes = types.filter(t =>
        t.title?.toLowerCase().includes(search.toLowerCase()) ||
        t.banner?.title?.toLowerCase().includes(search.toLowerCase())
    );

    const handleEditClick = (type) => {
        if (editingTypeId === type.id) {
            setEditingTypeId(null);
            setFormData({ title: '', status: 'DRAFT', image: null });
        } else {
            setEditingTypeId(type.id);
            setFormData({
                title: type.banner?.title || type.title || '',
                status: type.banner?.status || 'DRAFT',
                image: null,
            });
        }
    };

    const handleSubmit = (e, typeId) => {
        e.preventDefault();
        
        const data = new FormData();
        data.append('_method', 'PUT');
        data.append('title', formData.title);
        data.append('status', formData.status);
        
        if (formData.image) {
            data.append('image', formData.image);
        }

        Inertia.post(`/banners/${typeId}`, data, {
            onSuccess: () => {
                setEditingTypeId(null);
                setFormData({ title: '', status: 'DRAFT', image: null });
            }
        });
    };

    const getStatusLabel = (status) => {
        switch (status) {
            case 'DRAFT': return 'Desenvolvendo';
            case 'PENDING': return 'Pendente';
            case 'PUBLISHED': return 'Publicada';
            default: return status || 'Não Configurado';
        }
    };

    const getStatusBadge = (status) => {
        if (!status) {
            return (
                <span style={{
                    padding: '3px 10px',
                    borderRadius: '12px',
                    fontSize: '0.72rem',
                    fontWeight: 700,
                    backgroundColor: '#e2e8f0',
                    color: '#475569',
                }}>
                    Não Configurado
                </span>
            );
        }
        const styles = {
            PUBLISHED: { bg: '#dcfce7', color: '#166534' },
            PENDING: { bg: '#dbeafe', color: '#1e40af' },
            DRAFT: { bg: '#fef9c3', color: '#854d0e' },
        };
        const s = styles[status] || styles.DRAFT;
        return (
            <span style={{
                padding: '3px 10px',
                borderRadius: '12px',
                fontSize: '0.72rem',
                fontWeight: 700,
                backgroundColor: s.bg,
                color: s.color,
            }}>
                {getStatusLabel(status)}
            </span>
        );
    };

    return (
        <>
            <Head title="Gerenciamento de Banners" />

            <div style={{ padding: '32px', maxWidth: '1200px', margin: '0 auto' }}>
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

                {/* Header */}
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
                    <h1 style={{ fontSize: '1.75rem', fontWeight: 700, color: '#1e293b', margin: 0 }}>
                        🎨 Gerenciamento de Banners
                    </h1>
                </div>

                {/* Search */}
                <div style={{ marginBottom: '24px' }}>
                    <input
                        type="text"
                        placeholder="🔍 Buscar banner por nome ou tipo..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{
                            ...inputStyle,
                            maxWidth: '360px',
                        }}
                    />
                </div>

                {/* Grid of Banners */}
                {filteredTypes.length === 0 ? (
                    <p style={{ color: '#94a3b8', textAlign: 'center', padding: '48px 0' }}>
                        Nenhum tipo de banner encontrado.
                    </p>
                ) : (
                    <div style={{
                        display: 'grid',
                        gridTemplateColumns: '1fr',
                        gap: '24px',
                    }}>
                        {filteredTypes.map((type) => {
                            const isEditing = editingTypeId === type.id;
                            return (
                                <div key={type.id} style={{
                                    backgroundColor: '#fff',
                                    borderRadius: '12px',
                                    border: '1px solid #e2e8f0',
                                    boxShadow: '0 1px 3px rgba(0,0,0,0.04)',
                                    overflow: 'hidden',
                                }}>
                                    {/* Header */}
                                    <div style={{
                                        backgroundColor: '#f8fafc',
                                        padding: '16px 24px',
                                        borderBottom: '1px solid #e2e8f0',
                                        display: 'flex',
                                        justifyContent: 'space-between',
                                        alignItems: 'center',
                                    }}>
                                        <h3 style={{ fontSize: '1.1rem', fontWeight: 600, color: '#1e293b', margin: 0 }}>
                                            {type.title}
                                        </h3>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                                            {getStatusBadge(type.banner?.status)}
                                            <button
                                                onClick={() => handleEditClick(type)}
                                                style={{
                                                    padding: '6px 14px',
                                                    backgroundColor: isEditing ? '#64748b' : '#2563eb',
                                                    color: '#fff',
                                                    border: 'none',
                                                    borderRadius: '6px',
                                                    cursor: 'pointer',
                                                    fontSize: '0.85rem',
                                                    fontWeight: 600,
                                                }}
                                            >
                                                {isEditing ? '✕ Cancelar' : '✏️ Configurar'}
                                            </button>
                                        </div>
                                    </div>

                                    {/* Body */}
                                    <div style={{ padding: '24px' }}>
                                        {/* Current Banner Details */}
                                        {!isEditing && type.banner && (
                                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: '24px' }}>
                                                <div>
                                                    <span style={labelTitle}>Título do Banner</span>
                                                    <p style={{ margin: '4px 0 16px 0', fontWeight: 600, color: '#1e293b' }}>
                                                        {type.banner.title}
                                                    </p>
                                                    
                                                    <span style={labelTitle}>Caminho do Arquivo</span>
                                                    <p style={{ margin: '4px 0 0 0', fontSize: '0.8rem', color: '#64748b', wordBreak: 'break-all' }}>
                                                        {type.banner.image}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span style={labelTitle}>Imagem Atual</span>
                                                    <div style={{
                                                        width: '100%',
                                                        maxHeight: '180px',
                                                        backgroundColor: '#f1f5f9',
                                                        borderRadius: '8px',
                                                        overflow: 'hidden',
                                                        border: '1px solid #cbd5e1',
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        justifyContent: 'center',
                                                        marginTop: '4px',
                                                    }}>
                                                        <img
                                                            src={`/storage/images/banners/${type.banner.image}`}
                                                            alt={type.banner.title}
                                                            style={{ maxWidth: '100%', maxHeight: '180px', objectFit: 'contain' }}
                                                            onError={(e) => { e.target.src = ''; e.target.alt = 'Imagem não encontrada'; }}
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        )}

                                        {!isEditing && !type.banner && (
                                            <div style={{ textAlign: 'center', padding: '24px 0', color: '#94a3b8' }}>
                                                <p style={{ margin: 0, fontSize: '0.9rem' }}>Nenhum banner configurado para este tipo.</p>
                                            </div>
                                        )}

                                        {/* Edit Form */}
                                        {isEditing && (
                                            <form onSubmit={(e) => handleSubmit(e, type.id)}>
                                                <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '16px', marginBottom: '16px' }}>
                                                    <div>
                                                        <label style={labelStyle}>Título do Banner *</label>
                                                        <input
                                                            type="text"
                                                            value={formData.title}
                                                            onChange={e => setFormData({ ...formData, title: e.target.value })}
                                                            required
                                                            placeholder="Ex: Banner Informativo de Verão"
                                                            style={inputStyle}
                                                        />
                                                    </div>
                                                    <div>
                                                        <label style={labelStyle}>Status *</label>
                                                        <select
                                                            value={formData.status}
                                                            onChange={e => setFormData({ ...formData, status: e.target.value })}
                                                            required
                                                            style={inputStyle}
                                                        >
                                                            <option value="DRAFT">Desenvolvendo</option>
                                                            <option value="PENDING">Pendente</option>
                                                            <option value="PUBLISHED">Publicada</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div style={{ marginBottom: '20px' }}>
                                                    <label style={labelStyle}>
                                                        Selecionar Imagem do Banner * (Tamanho sugerido 1500x330)
                                                    </label>
                                                    <input
                                                        type="file"
                                                        accept="image/*"
                                                        onChange={e => setFormData({ ...formData, image: e.target.files[0] })}
                                                        required
                                                        style={inputStyle}
                                                    />
                                                </div>

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
                                                    Salvar Configurações
                                                </button>
                                            </form>
                                        )}
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                )}
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

const labelTitle = {
    fontSize: '0.8rem',
    color: '#94a3b8',
    fontWeight: 700,
    textTransform: 'uppercase',
    letterSpacing: '0.05em',
    display: 'block',
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
