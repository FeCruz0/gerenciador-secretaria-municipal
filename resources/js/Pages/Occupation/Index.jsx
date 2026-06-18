import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function OccupationIndex({ unit = null, occupations = [], departaments = [], occupation_selected = null }) {
    const [search, setSearch] = useState('');
    const [editingId, setEditingId] = useState(occupation_selected?.id ?? null);

    const filtered = occupations.filter(o =>
        o.title?.toLowerCase().includes(search.toLowerCase()) ||
        o.departament?.departament?.toLowerCase().includes(search.toLowerCase()) ||
        o.departament?.sigla?.toLowerCase().includes(search.toLowerCase())
    );

    // ── Formulário de Cadastro ──
    const createForm = useForm({
        title: '',
        departament_id: departaments[0]?.id ?? '',
        active: true,
    });

    function handleCreate(e) {
        e.preventDefault();
        createForm.post(route('ocupacoes.store'), {
            onSuccess: () => createForm.reset(),
        });
    }

    // ── Formulário de Edição ──
    const editForm = useForm({
        title: occupation_selected?.title ?? '',
        departament_id: occupation_selected?.departament_id ?? (departaments[0]?.id ?? ''),
        active: occupation_selected?.active ?? true,
    });

    function startEdit(occ) {
        setEditingId(occ.id);
        editForm.setData({
            title: occ.title,
            departament_id: occ.departament_id,
            active: !!occ.active,
        });
    }

    function handleUpdate(e, id) {
        e.preventDefault();
        editForm.put(route('ocupacoes.update', id), {
            onSuccess: () => setEditingId(null),
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta Ocupação?')) {
            Inertia.delete(route('ocupacoes.destroy', id));
        }
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 4, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '8px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const checkboxLabel = { display: 'flex', alignItems: 'center', gap: 8, color: '#f1f5f9', fontSize: 14, cursor: 'pointer', userSelect: 'none' };
    const checkbox = { width: 16, height: 16, cursor: 'pointer' };
    const btnPrimary  = { padding: '9px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnDanger   = { padding: '5px 10px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 12 };
    const btnEdit     = { padding: '5px 10px', borderRadius: 6, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40', cursor: 'pointer', fontSize: 12 };
    const btnSave     = { padding: '5px 12px', borderRadius: 6, background: '#065f4620', color: '#34d399', border: '1px solid #065f4660', cursor: 'pointer', fontSize: 12 };
    const btnCancel   = { padding: '5px 12px', borderRadius: 6, background: '#33415580', color: '#94a3b8', border: 'none', cursor: 'pointer', fontSize: 12 };

    const badgeActive = { display: 'inline-block', padding: '2px 8px', borderRadius: 12, fontSize: 11, fontWeight: 600, background: '#065f4630', color: '#34d399', border: '1px solid #065f4660' };
    const badgeInactive = { display: 'inline-block', padding: '2px 8px', borderRadius: 12, fontSize: 11, fontWeight: 600, background: '#7f1d1d30', color: '#f87171', border: '1px solid #7f1d1d60' };

    return (
        <AdminLayout title="Ocupações">
            <Head title="Ocupações" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Ocupações</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Configuração · {occupations.length} ocupaç{occupations.length !== 1 ? 'ões' : 'ão'} cadastrada{occupations.length !== 1 ? 's' : ''}
                    </p>
                </div>
                <Link
                    href={route('dashboard')}
                    style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}
                >
                    ← Dashboard
                </Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '360px 1fr', gap: 24, alignItems: 'start' }}>

                {/* ── Painel Esquerdo: Formulário de Cadastro ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>
                            ➕ Nova Ocupação
                        </h2>
                    </div>
                    <div style={{ padding: 20 }}>
                        <form onSubmit={handleCreate}>
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="new-title">Título da Ocupação *</label>
                                <input
                                    id="new-title"
                                    type="text"
                                    style={input}
                                    value={createForm.data.title}
                                    onChange={e => createForm.setData('title', e.target.value)}
                                    placeholder="Ex: Secretário Municipal"
                                    required
                                />
                                {createForm.errors.title && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.title}</p>
                                )}
                            </div>

                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="new-departament">Departamento *</label>
                                <select
                                    id="new-departament"
                                    style={input}
                                    value={createForm.data.departament_id}
                                    onChange={e => createForm.setData('departament_id', e.target.value)}
                                    required
                                >
                                    {departaments.map(d => (
                                        <option key={d.id} value={d.id}>
                                            {d.departament} {d.sigla ? `(${d.sigla})` : ''}
                                        </option>
                                    ))}
                                </select>
                                {createForm.errors.departament_id && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.departament_id}</p>
                                )}
                            </div>

                            <div style={{ marginBottom: 20 }}>
                                <label style={checkboxLabel} htmlFor="new-active">
                                    <input
                                        id="new-active"
                                        type="checkbox"
                                        style={checkbox}
                                        checked={createForm.data.active}
                                        onChange={e => createForm.setData('active', e.target.checked)}
                                    />
                                    Ocupação Ativa
                                </label>
                                {createForm.errors.active && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.active}</p>
                                )}
                            </div>

                            <div style={{ display: 'flex', gap: 8 }}>
                                <button type="submit" style={btnPrimary} disabled={createForm.processing}>
                                    {createForm.processing ? 'Salvando…' : 'Salvar'}
                                </button>
                                <button type="reset" onClick={() => createForm.reset()} style={{ ...btnCancel, background: 'transparent' }}>
                                    Limpar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {/* ── Painel Direito: Lista ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>📋 Ocupações Cadastradas</h2>
                        <input
                            type="text"
                            placeholder="Buscar ocupação ou depto..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ ...input, maxWidth: 240 }}
                        />
                    </div>

                    {filtered.length === 0 ? (
                        <div style={{ padding: 48, textAlign: 'center', color: '#64748b' }}>
                            <div style={{ fontSize: 36, marginBottom: 8 }}>💼</div>
                            <p style={{ margin: 0 }}>Nenhuma ocupação encontrada.</p>
                        </div>
                    ) : (
                        <div style={{ overflowX: 'auto' }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a50' }}>
                                        {['Ocupação', 'Departamento', 'Status', 'Ações'].map(h => (
                                            <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {filtered.map((occ, idx) => (
                                        <tr key={occ.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff02' }}>
                                            <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                                {editingId === occ.id ? (
                                                    <form onSubmit={e => handleUpdate(e, occ.id)} style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                                                        <input
                                                            type="text"
                                                            style={input}
                                                            value={editForm.data.title}
                                                            onChange={e => editForm.setData('title', e.target.value)}
                                                            placeholder="Título da Ocupação"
                                                            autoFocus
                                                            required
                                                        />
                                                        <select
                                                            style={input}
                                                            value={editForm.data.departament_id}
                                                            onChange={e => editForm.setData('departament_id', e.target.value)}
                                                            required
                                                        >
                                                            {departaments.map(d => (
                                                                <option key={d.id} value={d.id}>{d.departament}</option>
                                                            ))}
                                                        </select>
                                                        <label style={checkboxLabel}>
                                                            <input
                                                                type="checkbox"
                                                                style={checkbox}
                                                                checked={editForm.data.active}
                                                                onChange={e => editForm.setData('active', e.target.checked)}
                                                            />
                                                            Ativa
                                                        </label>
                                                        <div style={{ display: 'flex', gap: 6, marginTop: 4 }}>
                                                            <button type="submit" style={btnSave} disabled={editForm.processing}>✓ Salvar</button>
                                                            <button type="button" style={btnCancel} onClick={() => setEditingId(null)}>✕ Cancelar</button>
                                                        </div>
                                                    </form>
                                                ) : (
                                                    occ.title
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1' }}>
                                                {editingId !== occ.id && (
                                                    <>
                                                        <span style={{ fontWeight: 600 }}>{occ.departament?.departament ?? '—'}</span>
                                                        {occ.departament?.sigla && (
                                                            <span style={{ display: 'block', fontSize: 12, color: '#64748b', marginTop: 2 }}>
                                                                {occ.departament.sigla}
                                                            </span>
                                                        )}
                                                    </>
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px' }}>
                                                {editingId !== occ.id && (
                                                    occ.active ? (
                                                        <span style={badgeActive}>Ativo</span>
                                                    ) : (
                                                        <span style={badgeInactive}>Inativo</span>
                                                    )
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px' }}>
                                                {editingId !== occ.id && (
                                                    <div style={{ display: 'flex', gap: 6 }}>
                                                        <button onClick={() => startEdit(occ)} style={btnEdit}>Editar</button>
                                                        <button onClick={() => handleDelete(occ.id)} style={btnDanger}>Excluir</button>
                                                    </div>
                                                )}
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
