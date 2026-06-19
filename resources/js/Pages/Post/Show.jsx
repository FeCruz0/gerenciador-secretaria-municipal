import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ post_selected, media_web, media_phone, unit }) {
    const { flash } = usePage().props;

    const [formData, setFormData] = useState({
        title: post_selected.title || '',
        sub_title: post_selected.sub_title || '',
        order: post_selected.order || '',
        link: post_selected.link || '',
        content: post_selected.content || '',
        active: post_selected.active ? 1 : 0,
        image: null,
        image_mobile: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = new FormData();
        data.append('_method', 'PUT');
        data.append('title', formData.title);
        data.append('sub_title', formData.sub_title || '');
        data.append('order', formData.order || '');
        data.append('link', formData.link || '');
        data.append('content', formData.content || '');
        data.append('active', formData.active ? 1 : 0);

        if (formData.image) {
            data.append('image', formData.image);
        }
        if (formData.image_mobile) {
            data.append('image_mobile', formData.image_mobile);
        }

        Inertia.post(`/capas/${post_selected.id}`, data);
    };

    return (
        <>
            <Head title={`Capa - ${post_selected.title}`} />

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
                    href="/capas"
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
                    ← Voltar para as Capas
                </a>

                <h1 style={{ fontSize: '1.5rem', fontWeight: 700, color: '#1e293b', marginBottom: '24px' }}>
                    🖼️ {post_selected.title}
                </h1>

                {/* Imagens atuais */}
                <div style={{
                    display: 'grid',
                    gridTemplateColumns: '1fr 1fr',
                    gap: '20px',
                    marginBottom: '32px',
                }}>
                    <div style={imageCard}>
                        <h3 style={imageLabelStyle}>Imagem Web (Principal)</h3>
                        <div style={imageContainerStyle}>
                            {media_web ? (
                                <img
                                    src={`/storage/images/posts/${media_web.url}`}
                                    alt="Capa Web"
                                    style={{ maxWidth: '100%', maxHeight: '240px', objectFit: 'contain' }}
                                    onError={(e) => { e.target.src = ''; e.target.alt = 'Imagem não encontrada'; }}
                                />
                            ) : (
                                <span style={{ color: '#94a3b8', fontSize: '0.85rem' }}>Nenhuma imagem cadastrada</span>
                            )}
                        </div>
                        {media_web && <p style={imagePathStyle}>{media_web.url}</p>}
                    </div>

                    <div style={imageCard}>
                        <h3 style={imageLabelStyle}>Imagem Mobile (Opcional)</h3>
                        <div style={imageContainerStyle}>
                            {media_phone ? (
                                <img
                                    src={`/storage/images/posts/${media_phone.url}`}
                                    alt="Capa Mobile"
                                    style={{ maxWidth: '100%', maxHeight: '240px', objectFit: 'contain' }}
                                    onError={(e) => { e.target.src = ''; e.target.alt = 'Imagem não encontrada'; }}
                                />
                            ) : (
                                <span style={{ color: '#94a3b8', fontSize: '0.85rem' }}>Nenhuma imagem cadastrada</span>
                            )}
                        </div>
                        {media_phone && <p style={imagePathStyle}>{media_phone.url}</p>}
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
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr 1fr', gap: '16px' }}>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Status</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>
                                {post_selected.active ? 'Ativa' : 'Inativa'}
                            </p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Ordem</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>{post_selected.order || '—'}</p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Por</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>{post_selected.user?.name || '—'}</p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>ID</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>#{post_selected.id}</p>
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
                        ✏️ Editar Informações da Capa
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

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                            <div>
                                <label style={labelStyle}>Substituir Imagem Web</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image: e.target.files[0] })}
                                    style={inputStyle}
                                />
                            </div>
                            <div>
                                <label style={labelStyle}>Substituir/Adicionar Imagem Mobile</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setFormData({ ...formData, image_mobile: e.target.files[0] })}
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
