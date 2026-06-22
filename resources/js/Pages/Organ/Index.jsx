import React, { useState, useRef } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function OrganIndex({ organs = [], parentCandidates = [] }) {
    const [search, setSearch] = useState('');
    const [editingId, setEditingId] = useState(null);
    const fileInputRef = useRef(null);

    const filtered = organs.filter(o =>
        o.name?.toLowerCase().includes(search.toLowerCase()) ||
        o.sigla?.toLowerCase().includes(search.toLowerCase())
    );

    // Formulário Unificado (Cadastro / Edição)
    const form = useForm({
        name: '',
        sigla: '',
        theme_color_hex: '#4f46e5',
        parent_id: '',
        is_active: true,
        logo: null,
    });

    const [logoPreview, setLogoPreview] = useState(null);

    function handleLogoChange(e) {
        const file = e.target.files[0];
        if (file) {
            form.setData('logo', file);
            setLogoPreview(URL.createObjectURL(file));
        }
    }

    function startEdit(org) {
        setEditingId(org.id);
        form.setData({
            name: org.name,
            sigla: org.sigla,
            theme_color_hex: org.theme_color_hex || '#4f46e5',
            parent_id: org.parent_id || '',
            is_active: org.is_active,
            logo: null, // não recarregar o arquivo a menos que queira alterar
        });
        setLogoPreview(org.logo_path ? `/storage/${org.logo_path}` : null);
    }

    function cancelEdit() {
        setEditingId(null);
        form.reset();
        setLogoPreview(null);
        if (fileInputRef.current) fileInputRef.current.value = '';
    }

    function handleSubmit(e) {
        e.preventDefault();

        // Laravel/PHP requer envio como POST com _method=PUT para requests contendo arquivos via Multipart/Form-Data
        if (editingId) {
            // Edição
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', form.data.name);
            formData.append('sigla', form.data.sigla);
            formData.append('theme_color_hex', form.data.theme_color_hex);
            formData.append('is_active', form.data.is_active ? '1' : '0');
            if (form.data.parent_id) {
                formData.append('parent_id', form.data.parent_id);
            } else {
                formData.append('parent_id', '');
            }
            if (form.data.logo) {
                formData.append('logo', form.data.logo);
            }

            Inertia.post(route('orgaos.update', editingId), formData, {
                onSuccess: () => {
                    cancelEdit();
                }
            });
        } else {
            // Cadastro
            const formData = new FormData();
            formData.append('name', form.data.name);
            formData.append('sigla', form.data.sigla);
            formData.append('theme_color_hex', form.data.theme_color_hex);
            formData.append('is_active', form.data.is_active ? '1' : '0');
            if (form.data.parent_id) {
                formData.append('parent_id', form.data.parent_id);
            }
            if (form.data.logo) {
                formData.append('logo', form.data.logo);
            }

            Inertia.post(route('orgaos.store'), formData, {
                onSuccess: () => {
                    cancelEdit();
                }
            });
        }
    }

    function handleDelete(id) {
        if (confirm('Deseja realmente excluir este órgão? Subsecretarias vinculadas perderão o vínculo.')) {
            Inertia.delete(route('orgaos.destroy', id));
        }
    }

    // Estilos Visuais Dark Glassmorphism combinando com o Dashboard
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 4, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '8px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const checkboxLabel = { display: 'flex', alignItems: 'center', gap: 8, color: '#f1f5f9', fontSize: 14, cursor: 'pointer', userSelect: 'none' };
    const checkbox = { width: 16, height: 16, cursor: 'pointer' };
    const btnPrimary  = { padding: '9px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnDanger   = { padding: '5px 10px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 12 };
    const btnEdit     = { padding: '5px 10px', borderRadius: 6, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40', cursor: 'pointer', fontSize: 12 };
    const btnCancel   = { padding: '9px 20px', borderRadius: 8, background: '#33415580', color: '#94a3b8', border: '1px solid #334155', cursor: 'pointer', fontSize: 14 };

    const badgeActive = { display: 'inline-block', padding: '2px 8px', borderRadius: 12, fontSize: 11, fontWeight: 600, background: '#065f4630', color: '#34d399', border: '1px solid #065f4660' };
    const badgeInactive = { display: 'inline-block', padding: '2px 8px', borderRadius: 12, fontSize: 11, fontWeight: 600, background: '#7f1d1d30', color: '#f87171', border: '1px solid #7f1d1d60' };
    const badgeParent = { display: 'inline-block', padding: '2px 8px', borderRadius: 12, fontSize: 11, fontWeight: 600, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40' };

    return (
        <AdminLayout title="Órgãos e Subsecretarias">
            <Head title="Órgãos e Subsecretarias" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Órgãos & Subsecretarias</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Gerenciamento da estrutura administrativa municipal e subsecretarias.
                    </p>
                </div>
                <Link
                    href={route('dashboard')}
                    style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}
                >
                    ← Dashboard
                </Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '380px 1fr', gap: 24, alignItems: 'start' }}>

                {/* ── Painel Esquerdo: Formulário Unificado ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', background: editingId ? '#1e3a8a30' : 'transparent' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>
                            {editingId ? '✏️ Editar Órgão' : '➕ Novo Órgão / Subsecretaria'}
                        </h2>
                    </div>
                    <div style={{ padding: 20 }}>
                        <form onSubmit={handleSubmit}>
                            {/* Nome */}
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="name">Nome da Entidade *</label>
                                <input
                                    id="name"
                                    type="text"
                                    style={input}
                                    value={form.data.name}
                                    onChange={e => form.setData('name', e.target.value)}
                                    placeholder="Ex: Secretaria de Educação"
                                    required
                                />
                                {form.errors.name && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.name}</p>
                                )}
                            </div>

                            {/* Sigla */}
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="sigla">Sigla *</label>
                                <input
                                    id="sigla"
                                    type="text"
                                    style={input}
                                    value={form.data.sigla}
                                    onChange={e => form.setData('sigla', e.target.value)}
                                    placeholder="Ex: SMED"
                                    required
                                />
                                {form.errors.sigla && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.sigla}</p>
                                )}
                            </div>

                            {/* Órgão Pai (Vínculo para Subsecretarias) */}
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="parent_id">Órgão Pai (Vincular como Subsecretaria)</label>
                                <select
                                    id="parent_id"
                                    style={input}
                                    value={form.data.parent_id}
                                    onChange={e => form.setData('parent_id', e.target.value)}
                                >
                                    <option value="">-- Órgão Principal --</option>
                                    {parentCandidates
                                        .filter(p => !editingId || p.id !== editingId)
                                        .map(p => (
                                            <option key={p.id} value={p.id}>
                                                {p.name} ({p.sigla})
                                            </option>
                                        ))
                                    }
                                </select>
                                <p style={{ color: '#64748b', fontSize: 11, marginTop: 4 }}>
                                    Deixe em branco se for um órgão principal autônomo (ex: Secretarias centrais).
                                </p>
                                {form.errors.parent_id && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.parent_id}</p>
                                )}
                            </div>

                            {/* Cor de Tema Hex */}
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="theme_color_hex">Cor do Tema (Hexadecimal)</label>
                                <div style={{ display: 'flex', gap: 8 }}>
                                    <input
                                        type="color"
                                        style={{ width: 42, height: 38, border: '1px solid #334155', borderRadius: 8, background: 'transparent', cursor: 'pointer', padding: 2 }}
                                        value={form.data.theme_color_hex}
                                        onChange={e => form.setData('theme_color_hex', e.target.value)}
                                    />
                                    <input
                                        id="theme_color_hex"
                                        type="text"
                                        style={input}
                                        value={form.data.theme_color_hex}
                                        onChange={e => form.setData('theme_color_hex', e.target.value)}
                                        placeholder="#4f46e5"
                                        maxLength={7}
                                    />
                                </div>
                                {form.errors.theme_color_hex && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.theme_color_hex}</p>
                                )}
                            </div>

                            {/* Upload de Logo */}
                            <div style={{ marginBottom: 20 }}>
                                <label style={label} htmlFor="logo">Logo / Brasão</label>
                                <input
                                    id="logo"
                                    type="file"
                                    ref={fileInputRef}
                                    onChange={handleLogoChange}
                                    accept="image/*"
                                    style={{ ...input, padding: '6px 12px' }}
                                />
                                {logoPreview && (
                                    <div style={{ marginTop: 12, display: 'flex', alignItems: 'center', gap: 12 }}>
                                        <img
                                            src={logoPreview}
                                            alt="Preview da Logo"
                                            style={{ width: 48, height: 48, borderRadius: 8, objectFit: 'contain', border: '1px solid #334155', background: '#0f172a' }}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => {
                                                form.setData('logo', null);
                                                setLogoPreview(null);
                                                if (fileInputRef.current) fileInputRef.current.value = '';
                                            }}
                                            style={{ background: 'transparent', border: 'none', color: '#f87171', cursor: 'pointer', fontSize: 12 }}
                                        >
                                            Remover
                                        </button>
                                    </div>
                                )}
                                {form.errors.logo && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.logo}</p>
                                )}
                            </div>

                            {/* Status Ativo */}
                            <div style={{ marginBottom: 24 }}>
                                <label style={checkboxLabel} htmlFor="is_active">
                                    <input
                                        id="is_active"
                                        type="checkbox"
                                        style={checkbox}
                                        checked={form.data.is_active}
                                        onChange={e => form.setData('is_active', e.target.checked)}
                                    />
                                    Órgão Ativo e Publicado
                                </label>
                                {form.errors.is_active && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{form.errors.is_active}</p>
                                )}
                            </div>

                            {/* Ações */}
                            <div style={{ display: 'flex', gap: 8 }}>
                                <button type="submit" style={btnPrimary} disabled={form.processing}>
                                    {form.processing ? 'Salvando…' : 'Salvar'}
                                </button>
                                {editingId && (
                                    <button type="button" onClick={cancelEdit} style={btnCancel}>
                                        Cancelar
                                    </button>
                                )}
                                {!editingId && (
                                    <button type="button" onClick={() => { form.reset(); setLogoPreview(null); }} style={{ ...btnCancel, background: 'transparent' }}>
                                        Limpar
                                    </button>
                                )}
                            </div>
                        </form>
                    </div>
                </div>

                {/* ── Painel Direito: Lista de Órgãos ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>📋 Órgãos e Subsecretarias Cadastrados</h2>
                        <input
                            type="text"
                            placeholder="Buscar órgão ou sigla..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ ...input, maxWidth: 240 }}
                        />
                    </div>

                    {filtered.length === 0 ? (
                        <div style={{ padding: 48, textAlign: 'center', color: '#64748b' }}>
                            <div style={{ fontSize: 36, marginBottom: 8 }}>🏛️</div>
                            <p style={{ margin: 0 }}>Nenhum órgão ou subsecretaria encontrado.</p>
                        </div>
                    ) : (
                        <div style={{ overflowX: 'auto' }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a50' }}>
                                        {['Logo', 'Órgão / Secretaria', 'Sigla', 'Tipo / Vínculo', 'Cor', 'Status', 'Ações'].map(h => (
                                            <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {filtered.map((org, idx) => (
                                        <tr key={org.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff02' }}>
                                            {/* Logo */}
                                            <td style={{ padding: '12px 16px' }}>
                                                {org.logo_path ? (
                                                    <img
                                                        src={`/storage/${org.logo_path}`}
                                                        alt={org.name}
                                                        style={{ width: 32, height: 32, objectFit: 'contain', borderRadius: 4, background: '#0f172a', border: '1px solid #334155' }}
                                                    />
                                                ) : (
                                                    <div style={{ width: 32, height: 32, display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#334155', color: '#94a3b8', borderRadius: 4, fontWeight: 700, fontSize: 12 }}>
                                                        {org.sigla?.substring(0, 2)}
                                                    </div>
                                                )}
                                            </td>

                                            {/* Nome */}
                                            <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                                {org.name}
                                                <div style={{ fontSize: 11, color: '#64748b', marginTop: 2 }}>
                                                    slug: /{org.slug}
                                                </div>
                                            </td>

                                            {/* Sigla */}
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1' }}>
                                                {org.sigla}
                                            </td>

                                            {/* Vínculo (Se é subsecretaria) */}
                                            <td style={{ padding: '12px 16px' }}>
                                                {org.parent ? (
                                                    <div>
                                                        <span style={badgeParent}>Subsecretaria</span>
                                                        <div style={{ fontSize: 11, color: '#94a3b8', marginTop: 4 }}>
                                                            Vinculada a: <strong>{org.parent.name}</strong>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <span style={{ fontSize: 12, color: '#64748b' }}>Órgão Principal</span>
                                                )}
                                            </td>

                                            {/* Cor */}
                                            <td style={{ padding: '12px 16px' }}>
                                                <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
                                                    <div style={{ width: 14, height: 14, borderRadius: '50%', background: org.theme_color_hex || '#4f46e5', border: '1px solid #ffffff30' }}></div>
                                                    <span style={{ fontSize: 12, color: '#94a3b8', fontFamily: 'monospace' }}>{org.theme_color_hex || '#4f46e5'}</span>
                                                </div>
                                            </td>

                                            {/* Status */}
                                            <td style={{ padding: '12px 16px' }}>
                                                {org.is_active ? (
                                                    <span style={badgeActive}>Ativo</span>
                                                ) : (
                                                    <span style={badgeInactive}>Inativo</span>
                                                )}
                                            </td>

                                            {/* Ações */}
                                            <td style={{ padding: '12px 16px' }}>
                                                <div style={{ display: 'flex', gap: 6 }}>
                                                    <button onClick={() => startEdit(org)} style={btnEdit}>Editar</button>
                                                    <button onClick={() => handleDelete(org.id)} style={btnDanger}>Excluir</button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
