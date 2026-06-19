import React, { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ shortcut_web_selected, shortcut_webs, unit }) {
    const { flash } = usePage().props;
    const [formData, setFormData] = useState({
        title: shortcut_web_selected.title || '',
        link_url: shortcut_web_selected.link_url || '',
        order: shortcut_web_selected.order || '',
        status: shortcut_web_selected.status || 'DRAFT',
        image_icon: null, // Campo opcional para novo ícone
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        setFormData({
            title: shortcut_web_selected.title || '',
            link_url: shortcut_web_selected.link_url || '',
            order: shortcut_web_selected.order || '',
            status: shortcut_web_selected.status || 'DRAFT',
            image_icon: null,
        });
        setErrors({});
    }, [shortcut_web_selected]);

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        // Para requisições com upload de arquivo no update,
        // o PHP/Inertia requer um POST com o campo spoofing _method: 'PUT'
        const payload = {
            title: formData.title,
            link_url: formData.link_url,
            order: formData.order,
            status: formData.status,
            _method: 'PUT'
        };

        if (formData.image_icon) {
            payload.image_icon = formData.image_icon;
        }

        Inertia.post(`/web_atalhos/${shortcut_web_selected.id}`, payload, {
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este Atalho?')) {
            Inertia.delete(`/web_atalhos/${id}`);
        }
    };

    return (
        <>
            <Head title={`Editar Atalho - ${shortcut_web_selected.title}`} />

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

                {/* Back button */}
                <div style={{ marginBottom: '20px' }}>
                    <a href="/web_atalhos" style={{
                        color: '#2563eb',
                        textDecoration: 'none',
                        fontWeight: 600,
                        fontSize: '0.9rem',
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '4px'
                    }}>
                        ← Voltar para a Lista de Atalhos
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
                            <h2 style={{ fontSize: '1.2rem', fontWeight: 700, marginBottom: '20px', color: '#1e293b' }}>
                                ✏️ Editar Atalho
                            </h2>

                            <div style={{ marginBottom: '16px' }}>
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

                            <div style={{ marginBottom: '16px' }}>
                                <label style={labelStyle}>Link de Acesso *</label>
                                <input
                                    type="text"
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

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '16px' }}>
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

                            <div style={{ marginBottom: '16px' }}>
                                <label style={labelStyle}>Ícone Atual</label>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginTop: '4px' }}>
                                    <img
                                        src={`/storage/images/shortcutweb/${shortcut_web_selected.img_url}`}
                                        alt={shortcut_web_selected.title}
                                        style={{ width: '64px', height: '64px', objectFit: 'cover', borderRadius: '8px', border: '1px solid #e2e8f0' }}
                                    />
                                    <span style={{ fontSize: '0.8rem', color: '#64748b' }}>
                                        Dimensões recomendadas: proporcionais.
                                    </span>
                                </div>
                            </div>

                            <div style={{ marginBottom: '24px' }}>
                                <label style={labelStyle}>Alterar Ícone (Opcional)</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_icon: e.target.files[0] })}
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
                                    onClick={() => handleDelete(shortcut_web_selected.id)}
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

                    {/* Right Column: Shortcuts List */}
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
                                    Atalhos Cadastrados
                                </h3>
                            </div>
                            <div style={{ maxHeight: '600px', overflowY: 'auto' }}>
                                <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                                    <tbody>
                                        {shortcut_webs.map((shortcut) => {
                                            const isSelected = shortcut.id === shortcut_web_selected.id;
                                            return (
                                                <tr
                                                    key={shortcut.id}
                                                    style={{
                                                        borderBottom: '1px solid #f1f5f9',
                                                        backgroundColor: isSelected ? '#f1f5f9' : 'transparent',
                                                    }}
                                                >
                                                    <td style={{ ...tdStyle, width: '64px', padding: '12px 24px' }}>
                                                        <img
                                                            src={`/storage/images/shortcutweb/${shortcut.img_url}`}
                                                            alt={shortcut.title}
                                                            style={{ width: '40px', height: '40px', objectFit: 'cover', borderRadius: '6px', border: '1px solid #e2e8f0' }}
                                                        />
                                                    </td>
                                                    <td style={{ ...tdStyle, padding: '12px' }}>
                                                        <a
                                                            href={`/web_atalhos/${shortcut.id}`}
                                                            style={{
                                                                fontWeight: isSelected ? 700 : 500,
                                                                color: isSelected ? '#2563eb' : '#475569',
                                                                textDecoration: 'none',
                                                                display: 'block'
                                                            }}
                                                        >
                                                            {shortcut.title}
                                                            {isSelected && ' (Editando)'}
                                                        </a>
                                                        <span style={{ fontSize: '0.75rem', color: '#94a3b8', display: 'block', marginTop: '2px' }}>
                                                            Ordem: {shortcut.order} | Link: {shortcut.link_url.substring(0, 40)}...
                                                        </span>
                                                    </td>
                                                    <td style={{ ...tdStyle, textAlign: 'right', padding: '12px 24px' }}>
                                                        <span style={{
                                                            fontSize: '0.7rem',
                                                            fontWeight: 600,
                                                            padding: '2px 8px',
                                                            borderRadius: '10px',
                                                            backgroundColor: shortcut.status === 'PUBLISHED' ? '#dcfce7' : (shortcut.status === 'PENDING' ? '#dbeafe' : '#fef9c3'),
                                                            color: shortcut.status === 'PUBLISHED' ? '#166534' : (shortcut.status === 'PENDING' ? '#1e40af' : '#854d0e')
                                                        }}>
                                                            {shortcut.status === 'PUBLISHED' ? 'Publicado' : (shortcut.status === 'PENDING' ? 'Pendente' : 'Editando')}
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
