import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ shortcut_webs, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [showForm, setShowForm] = useState(false);

    // Form state
    const [formData, setFormData] = useState({
        title: '',
        link_url: '',
        order: '',
        status: 'DRAFT',
        image_icon: null,
    });
    const [errors, setErrors] = useState({});

    const filtered = shortcut_webs.filter(s =>
        s.title?.toLowerCase().includes(search.toLowerCase()) ||
        s.link_url?.toLowerCase().includes(search.toLowerCase())
    );

    const resetForm = () => {
        setFormData({
            title: '',
            link_url: '',
            order: '',
            status: 'DRAFT',
            image_icon: null,
        });
        setErrors({});
        setShowForm(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        // Inertia converte automaticamente para FormData caso haja arquivos no payload
        Inertia.post('/web_atalhos', formData, {
            onSuccess: () => resetForm(),
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este Atalho?')) {
            Inertia.delete(`/web_atalhos/${id}`);
        }
    };

    const getStatusLabel = (status) => {
        switch (status) {
            case 'DRAFT': return 'Editando';
            case 'PENDING': return 'Pendente';
            case 'PUBLISHED': return 'Publicado';
            default: return status;
        }
    };

    const getStatusBadge = (status) => {
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
            <Head title="Atalhos Web" />

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

                {/* Header */}
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
                    <h1 style={{ fontSize: '1.75rem', fontWeight: 700, color: '#1e293b', margin: 0 }}>
                        🔗 Atalhos Web
                    </h1>
                    <button
                        onClick={() => {
                            if (!showForm) {
                                resetForm();
                                setShowForm(true);
                            } else {
                                resetForm();
                            }
                        }}
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
                        {showForm ? '✕ Cancelar' : '+ Novo Atalho'}
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
                            📤 Cadastrar Novo Atalho
                        </h2>

                        <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '16px', marginBottom: '16px' }}>
                            <div>
                                <label style={labelStyle}>Nome do Atalho *</label>
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
                            <div>
                                <label style={labelStyle}>Ordem *</label>
                                <input
                                    type="number"
                                    value={formData.order}
                                    onChange={e => setFormData({ ...formData, order: e.target.value })}
                                    required
                                    style={{
                                        ...inputStyle,
                                        borderColor: errors.order ? '#ef4444' : '#cbd5e1'
                                    }}
                                />
                                {errors.order && (
                                    <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                        {errors.order}
                                    </span>
                                )}
                            </div>
                        </div>

                        <div style={{ marginBottom: '16px' }}>
                            <label style={labelStyle}>Link de Acesso *</label>
                            <input
                                type="text"
                                placeholder="Ex: https://www.google.com/"
                                value={formData.link_url}
                                onChange={e => setFormData({ ...formData, link_url: e.target.value })}
                                required
                                style={{
                                    ...inputStyle,
                                    borderColor: errors.link_url ? '#ef4444' : '#cbd5e1'
                                }}
                            />
                            {errors.link_url && (
                                <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                    {errors.link_url}
                                </span>
                            )}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '24px' }}>
                            <div>
                                <label style={labelStyle}>Ícone (Imagem) *</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_icon: e.target.files[0] })}
                                    required
                                    style={{
                                        ...inputStyle,
                                        borderColor: errors.image_icon ? '#ef4444' : '#cbd5e1'
                                    }}
                                />
                                {errors.image_icon && (
                                    <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                        {errors.image_icon}
                                    </span>
                                )}
                            </div>
                            <div>
                                <label style={labelStyle}>Status *</label>
                                <select
                                    value={formData.status}
                                    onChange={e => setFormData({ ...formData, status: e.target.value })}
                                    required
                                    style={inputStyle}
                                >
                                    <option value="DRAFT">Desenvolvendo (Draft)</option>
                                    <option value="PENDING">Pendente (Pending)</option>
                                    <option value="PUBLISHED">Publicado (Published)</option>
                                </select>
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
                            Cadastrar Atalho
                        </button>
                    </form>
                )}

                {/* Search */}
                <div style={{ marginBottom: '20px' }}>
                    <input
                        type="text"
                        placeholder="🔍 Buscar atalho por nome ou link..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{
                            ...inputStyle,
                            maxWidth: '360px',
                        }}
                    />
                </div>

                {/* List / Table */}
                {filtered.length === 0 ? (
                    <p style={{ color: '#94a3b8', textAlign: 'center', padding: '48px 0' }}>
                        Nenhum atalho web encontrado.
                    </p>
                ) : (
                    <div style={{
                        backgroundColor: '#fff',
                        borderRadius: '12px',
                        border: '1px solid #e2e8f0',
                        overflow: 'hidden',
                        boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                    }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                            <thead>
                                <tr style={{ backgroundColor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                                    <th style={thStyle}>Ícone</th>
                                    <th style={thStyle}>Nome</th>
                                    <th style={thStyle}>Link</th>
                                    <th style={thStyle}>Ordem</th>
                                    <th style={thStyle}>Status</th>
                                    <th style={{ ...thStyle, textAlign: 'right' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((shortcut) => (
                                    <tr key={shortcut.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                                        <td style={tdStyle}>
                                            <img
                                                src={`/storage/images/shortcutweb/${shortcut.img_url}`}
                                                alt={shortcut.title}
                                                style={{ width: '48px', height: '48px', objectFit: 'cover', borderRadius: '8px', border: '1px solid #e2e8f0' }}
                                            />
                                        </td>
                                        <td style={tdStyle}>
                                            <div style={{ fontWeight: 600, color: '#1e293b' }}>{shortcut.title}</div>
                                        </td>
                                        <td style={{ ...tdStyle, color: '#64748b', fontSize: '0.85rem' }}>
                                            <a href={shortcut.link_url} target="_blank" rel="noopener noreferrer" style={{ color: '#2563eb', textDecoration: 'none' }}>
                                                {shortcut.link_url}
                                            </a>
                                        </td>
                                        <td style={tdStyle}>
                                            <span style={{ fontWeight: 600, color: '#475569' }}>{shortcut.order}</span>
                                        </td>
                                        <td style={tdStyle}>
                                            {getStatusBadge(shortcut.status)}
                                        </td>
                                        <td style={{ ...tdStyle, textAlign: 'right' }}>
                                            <div style={{ display: 'inline-flex', gap: '8px' }}>
                                                <a
                                                    href={`/web_atalhos/${shortcut.id}`}
                                                    style={btnSmall('#2563eb')}
                                                >
                                                    👁 Ver / Editar
                                                </a>
                                                <button
                                                    onClick={() => handleDelete(shortcut.id)}
                                                    style={btnSmall('#ef4444')}
                                                >
                                                    🗑 Excluir
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
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

const thStyle = {
    padding: '12px 16px',
    fontSize: '0.8rem',
    fontWeight: 700,
    color: '#475569',
    textTransform: 'uppercase',
    letterSpacing: '0.05em',
};

const tdStyle = {
    padding: '16px',
    fontSize: '0.9rem',
    verticalAlign: 'middle',
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
