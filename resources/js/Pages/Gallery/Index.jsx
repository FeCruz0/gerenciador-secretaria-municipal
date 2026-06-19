import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ galleries, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState(null);

    // Form state
    const [formData, setFormData] = useState({
        title: '',
        order: '',
        status: 'DRAFT',
        image_small: null,
        image_large: null,
    });

    const filtered = galleries.filter(g =>
        g.title?.toLowerCase().includes(search.toLowerCase())
    );

    const resetForm = () => {
        setFormData({ title: '', order: '', status: 'DRAFT', image_small: null, image_large: null });
        setEditingId(null);
        setShowForm(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = new FormData();
        data.append('title', formData.title);
        data.append('order', formData.order || '');
        data.append('status', formData.status);

        if (formData.image_small) data.append('image_small', formData.image_small);
        if (formData.image_large) data.append('image_large', formData.image_large);

        if (editingId) {
            data.append('_method', 'PUT');
            Inertia.post(`/galeria_imagens/${editingId}`, data, {
                onSuccess: () => resetForm(),
            });
        } else {
            Inertia.post('/galeria_imagens', data, {
                onSuccess: () => resetForm(),
            });
        }
    };

    const handleEdit = (gallery) => {
        setFormData({
            title: gallery.title || '',
            order: gallery.order || '',
            status: gallery.status || 'DRAFT',
            image_small: null,
            image_large: null,
        });
        setEditingId(gallery.id);
        setShowForm(true);
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir esta imagem da galeria?')) {
            Inertia.delete(`/galeria_imagens/${id}`);
        }
    };

    const statusBadge = (status) => {
        const colors = {
            PUBLISHED: { bg: '#dcfce7', color: '#166534' },
            DRAFT: { bg: '#fef9c3', color: '#854d0e' },
            PENDING: { bg: '#dbeafe', color: '#1e40af' },
        };
        const s = colors[status] || colors.DRAFT;
        return (
            <span style={{
                padding: '2px 10px',
                borderRadius: '12px',
                fontSize: '0.75rem',
                fontWeight: 600,
                backgroundColor: s.bg,
                color: s.color,
            }}>
                {status}
            </span>
        );
    };

    return (
        <>
            <Head title="Galeria de Imagens" />

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
                        📸 Galeria de Imagens
                    </h1>
                    <button
                        onClick={() => { resetForm(); setShowForm(!showForm); }}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: showForm ? '#64748b' : '#2563eb',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                            fontSize: '0.9rem',
                        }}
                    >
                        {showForm ? '✕ Cancelar' : '+ Nova Imagem'}
                    </button>
                </div>

                {/* Form */}
                {showForm && (
                    <form onSubmit={handleSubmit} style={{
                        backgroundColor: '#f8fafc',
                        padding: '24px',
                        borderRadius: '12px',
                        marginBottom: '24px',
                        border: '1px solid #e2e8f0',
                    }}>
                        <h2 style={{ fontSize: '1.1rem', fontWeight: 600, marginBottom: '16px', color: '#334155' }}>
                            {editingId ? '✏️ Editar Imagem' : '📤 Adicionar Nova Imagem'}
                        </h2>
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
                                        <option value="DRAFT">Rascunho</option>
                                        <option value="PUBLISHED">Publicado</option>
                                        <option value="PENDING">Pendente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                            <div>
                                <label style={labelStyle}>
                                    Imagem Pequena {!editingId && '*'}
                                </label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_small: e.target.files[0] })}
                                    required={!editingId}
                                    style={inputStyle}
                                />
                            </div>
                            <div>
                                <label style={labelStyle}>
                                    Imagem Grande {!editingId && '*'}
                                </label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_large: e.target.files[0] })}
                                    required={!editingId}
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
                            {editingId ? 'Salvar Alterações' : 'Cadastrar'}
                        </button>
                    </form>
                )}

                {/* Search */}
                <div style={{ marginBottom: '20px' }}>
                    <input
                        type="text"
                        placeholder="🔍 Buscar por título..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{
                            ...inputStyle,
                            maxWidth: '360px',
                        }}
                    />
                </div>

                {/* Grid */}
                {filtered.length === 0 ? (
                    <p style={{ color: '#94a3b8', textAlign: 'center', padding: '48px 0' }}>
                        Nenhuma imagem encontrada.
                    </p>
                ) : (
                    <div style={{
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))',
                        gap: '20px',
                    }}>
                        {filtered.map(gallery => (
                            <div key={gallery.id} style={{
                                backgroundColor: '#fff',
                                borderRadius: '12px',
                                border: '1px solid #e2e8f0',
                                overflow: 'hidden',
                                transition: 'box-shadow 0.2s',
                                boxShadow: '0 1px 3px rgba(0,0,0,0.06)',
                            }}>
                                {gallery.image_small && (
                                    <div style={{
                                        width: '100%',
                                        height: '180px',
                                        backgroundColor: '#f1f5f9',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        overflow: 'hidden',
                                    }}>
                                        <img
                                            src={`/storage/gallery/${gallery.image_small}`}
                                            alt={gallery.title}
                                            style={{ maxWidth: '100%', maxHeight: '100%', objectFit: 'cover' }}
                                            onError={(e) => { e.target.style.display = 'none'; }}
                                        />
                                    </div>
                                )}
                                <div style={{ padding: '16px' }}>
                                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '8px' }}>
                                        <h3 style={{ fontSize: '1rem', fontWeight: 600, color: '#1e293b', margin: 0 }}>
                                            {gallery.title || 'Sem título'}
                                        </h3>
                                        {statusBadge(gallery.status)}
                                    </div>
                                    {gallery.order && (
                                        <p style={{ fontSize: '0.8rem', color: '#94a3b8', margin: '0 0 12px 0' }}>
                                            Ordem: {gallery.order}
                                        </p>
                                    )}
                                    <div style={{ display: 'flex', gap: '8px' }}>
                                        <a
                                            href={`/galeria_imagens/${gallery.id}`}
                                            style={btnSmall('#2563eb')}
                                        >
                                            👁 Ver
                                        </a>
                                        <button
                                            onClick={() => handleEdit(gallery)}
                                            style={btnSmall('#f59e0b')}
                                        >
                                            ✏️ Editar
                                        </button>
                                        <button
                                            onClick={() => handleDelete(gallery.id)}
                                            style={btnSmall('#ef4444')}
                                        >
                                            🗑 Excluir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
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

const inputStyle = {
    width: '100%',
    padding: '8px 12px',
    borderRadius: '6px',
    border: '1px solid #cbd5e1',
    fontSize: '0.9rem',
    outline: 'none',
    boxSizing: 'border-box',
};

const btnSmall = (bg) => ({
    padding: '5px 12px',
    backgroundColor: bg,
    color: '#fff',
    border: 'none',
    borderRadius: '6px',
    cursor: 'pointer',
    fontSize: '0.78rem',
    fontWeight: 600,
    textDecoration: 'none',
    display: 'inline-block',
});
