import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ posts, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState(null);

    // Form state
    const [formData, setFormData] = useState({
        title: '',
        sub_title: '',
        order: '',
        link: '',
        content: '',
        active: 1,
        image_web: null,
    });

    const filtered = posts.filter(p =>
        p.title?.toLowerCase().includes(search.toLowerCase()) ||
        p.sub_title?.toLowerCase().includes(search.toLowerCase())
    );

    const resetForm = () => {
        setFormData({
            title: '',
            sub_title: '',
            order: '',
            link: '',
            content: '',
            active: 1,
            image_web: null,
        });
        setEditingId(null);
        setShowForm(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = new FormData();
        data.append('title', formData.title);
        data.append('sub_title', formData.sub_title || '');
        data.append('order', formData.order || '');
        data.append('link', formData.link || '');
        data.append('content', formData.content || '');
        data.append('active', formData.active ? 1 : 0);

        if (formData.image_web) {
            data.append('image_web', formData.image_web);
        }

        if (editingId) {
            data.append('_method', 'PUT');
            // Wait, standard route for PUT is /capas/{id}
            Inertia.post(`/capas/${editingId}`, data, {
                onSuccess: () => resetForm(),
            });
        } else {
            Inertia.post('/capas', data, {
                onSuccess: () => resetForm(),
            });
        }
    };

    const handleEdit = (post) => {
        setFormData({
            title: post.title || '',
            sub_title: post.sub_title || '',
            order: post.order || '',
            link: post.link || '',
            content: post.content || '',
            active: post.active ? 1 : 0,
            image_web: null,
        });
        setEditingId(post.id);
        setShowForm(true);
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir esta capa do site?')) {
            Inertia.delete(`/capas/${id}`);
        }
    };

    return (
        <>
            <Head title="Capas do Site" />

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
                        🖼️ Capas do Site
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
                        {showForm ? '✕ Cancelar' : '+ Nova Capa'}
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
                            {editingId ? '✏️ Editar Capa' : '📤 Adicionar Nova Capa'}
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
                            <div>
                                <label style={labelStyle}>Subtítulo</label>
                                <input
                                    type="text"
                                    value={formData.sub_title}
                                    onChange={e => setFormData({ ...formData, sub_title: e.target.value })}
                                    style={inputStyle}
                                />
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '16px', marginBottom: '16px' }}>
                            <div>
                                <label style={labelStyle}>Link (URL)</label>
                                <input
                                    type="url"
                                    value={formData.link}
                                    onChange={e => setFormData({ ...formData, link: e.target.value })}
                                    placeholder="https://exemplo.com"
                                    style={inputStyle}
                                />
                            </div>
                            <div>
                                <label style={labelStyle}>Ordem de Exibição</label>
                                <input
                                    type="number"
                                    value={formData.order}
                                    onChange={e => setFormData({ ...formData, order: e.target.value })}
                                    style={inputStyle}
                                />
                            </div>
                            <div style={{ display: 'flex', alignItems: 'center', marginTop: '24px' }}>
                                <label style={{ display: 'inline-flex', alignItems: 'center', cursor: 'pointer', fontSize: '0.9rem', fontWeight: 600, color: '#475569' }}>
                                    <input
                                        type="checkbox"
                                        checked={formData.active}
                                        onChange={e => setFormData({ ...formData, active: e.target.checked })}
                                        style={{ marginRight: '8px', width: '16px', height: '16px' }}
                                    />
                                    Capa Ativa
                                </label>
                            </div>
                        </div>

                        <div style={{ marginBottom: '16px' }}>
                            <label style={labelStyle}>Conteúdo / Descrição</label>
                            <textarea
                                value={formData.content}
                                onChange={e => setFormData({ ...formData, content: e.target.value })}
                                rows="3"
                                style={{ ...inputStyle, fontFamily: 'inherit', resize: 'vertical' }}
                            />
                        </div>

                        <div style={{ marginBottom: '20px', maxWidth: '50%' }}>
                            <label style={labelStyle}>
                                Imagem Web (Destaque principal) {!editingId && '*'}
                            </label>
                            <input
                                type="file"
                                accept="image/*"
                                onChange={e => setFormData({ ...formData, image_web: e.target.files[0] })}
                                required={!editingId}
                                style={inputStyle}
                            />
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
                        placeholder="🔍 Buscar capa por título ou subtítulo..."
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
                        Nenhuma capa do site cadastrada.
                    </p>
                ) : (
                    <div style={{
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))',
                        gap: '20px',
                    }}>
                        {filtered.map(post => {
                            const mediaWeb = post.media?.find(m => m.type_media_id === 1);
                            return (
                                <div key={post.id} style={{
                                    backgroundColor: '#fff',
                                    borderRadius: '12px',
                                    border: '1px solid #e2e8f0',
                                    overflow: 'hidden',
                                    transition: 'box-shadow 0.2s',
                                    boxShadow: '0 1px 3px rgba(0,0,0,0.06)',
                                }}>
                                    <div style={{
                                        width: '100%',
                                        height: '180px',
                                        backgroundColor: '#f1f5f9',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        overflow: 'hidden',
                                        position: 'relative'
                                    }}>
                                        {mediaWeb ? (
                                            <img
                                                src={`/storage/images/posts/${mediaWeb.url}`}
                                                alt={post.title}
                                                style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                                                onError={(e) => { e.target.style.display = 'none'; }}
                                            />
                                        ) : (
                                            <span style={{ color: '#94a3b8', fontSize: '0.85rem' }}>Sem imagem</span>
                                        )}
                                        <div style={{
                                            position: 'absolute',
                                            top: '12px',
                                            right: '12px',
                                        }}>
                                            <span style={{
                                                padding: '4px 10px',
                                                borderRadius: '12px',
                                                fontSize: '0.7rem',
                                                fontWeight: 700,
                                                backgroundColor: post.active ? '#dcfce7' : '#fee2e2',
                                                color: post.active ? '#166534' : '#991b1b',
                                            }}>
                                                {post.active ? 'Ativa' : 'Inativa'}
                                            </span>
                                        </div>
                                    </div>
                                    <div style={{ padding: '16px' }}>
                                        <h3 style={{ fontSize: '1rem', fontWeight: 600, color: '#1e293b', margin: '0 0 4px 0', lineClamp: 1, display: '-webkit-box', WebkitLineClamp: 1, WebkitBoxOrient: 'vertical', overflow: 'hidden' }}>
                                            {post.title || 'Sem título'}
                                        </h3>
                                        <p style={{ fontSize: '0.85rem', color: '#64748b', margin: '0 0 12px 0', lineClamp: 2, display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical', overflow: 'hidden', minHeight: '34px' }}>
                                            {post.sub_title || 'Sem subtítulo'}
                                        </p>
                                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', fontSize: '0.75rem', color: '#94a3b8', marginBottom: '16px' }}>
                                            <span>Ordem: {post.order ?? '—'}</span>
                                            <span>Por: {post.user?.name || 'Sistema'}</span>
                                        </div>
                                        <div style={{ display: 'flex', gap: '8px' }}>
                                            <a
                                                href={`/capas/${post.id}`}
                                                style={btnSmall('#2563eb')}
                                            >
                                                👁 Ver
                                            </a>
                                            <button
                                                onClick={() => handleEdit(post)}
                                                style={btnSmall('#f59e0b')}
                                            >
                                                ✏️ Editar
                                            </button>
                                            <button
                                                onClick={() => handleDelete(post.id)}
                                                style={btnSmall('#ef4444')}
                                            >
                                                🗑 Excluir
                                            </button>
                                        </div>
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
    display: 'inline-flex',
    alignItems: 'center',
    justifyContent: 'center',
});
