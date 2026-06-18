import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function DepartmentIndex({ departaments = [], units = [], departament_selected = null }) {
    const [search, setSearch] = useState('');
    const [editingId, setEditingId] = useState(departament_selected?.id ?? null);

    const filtered = departaments.filter(d =>
        d.departament?.toLowerCase().includes(search.toLowerCase()) ||
        d.sigla?.toLowerCase().includes(search.toLowerCase())
    );

    // ── Formulário de Cadastro ──
    const createForm = useForm({
        departament: '',
        sigla: '',
        unit_id: units[0]?.id ?? '',
        code: '',
        responsible: '',
        phone: '',
        email: '',
    });

    function handleCreate(e) {
        e.preventDefault();
        createForm.post(route('departamentos.store'), {
            onSuccess: () => createForm.reset(),
        });
    }

    // ── Formulário de Edição ──
    const editForm = useForm({
        departament: departament_selected?.departament ?? '',
        sigla: departament_selected?.sigla ?? '',
        unit_id: departament_selected?.unit_id ?? (units[0]?.id ?? ''),
        code: departament_selected?.code ?? '',
        responsible: departament_selected?.responsible ?? '',
        phone: departament_selected?.phone ?? '',
        email: departament_selected?.email ?? '',
    });

    function startEdit(dep) {
        setEditingId(dep.id);
        editForm.setData({
            departament: dep.departament,
            sigla: dep.sigla,
            unit_id: dep.unit_id,
            code: dep.code ?? '',
            responsible: dep.responsible ?? '',
            phone: dep.phone ?? '',
            email: dep.email ?? '',
        });
    }

    function handleUpdate(e, id) {
        e.preventDefault();
        editForm.put(route('departamentos.update', id), {
            onSuccess: () => setEditingId(null),
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir este Departamento?')) {
            Inertia.delete(route('departamentos.destroy', id));
        }
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 4, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '8px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const btnPrimary  = { padding: '9px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnDanger   = { padding: '5px 10px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 12 };
    const btnEdit     = { padding: '5px 10px', borderRadius: 6, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40', cursor: 'pointer', fontSize: 12 };
    const btnSave     = { padding: '5px 12px', borderRadius: 6, background: '#065f4620', color: '#34d399', border: '1px solid #065f4660', cursor: 'pointer', fontSize: 12 };
    const btnCancel   = { padding: '5px 12px', borderRadius: 6, background: '#33415580', color: '#94a3b8', border: 'none', cursor: 'pointer', fontSize: 12 };

    return (
        <AdminLayout title="Departamentos">
            <Head title="Departamentos" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Departamentos</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Configuração · {departaments.length} departamento{departaments.length !== 1 ? 's' : ''} cadastrado{departaments.length !== 1 ? 's' : ''}
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
                            ➕ Novo Departamento
                        </h2>
                    </div>
                    <div style={{ padding: 20 }}>
                        <form onSubmit={handleCreate}>
                            <div style={{ marginBottom: 12 }}>
                                <label style={label} htmlFor="new-dep">Nome do Departamento *</label>
                                <input
                                    id="new-dep"
                                    type="text"
                                    style={input}
                                    value={createForm.data.departament}
                                    onChange={e => createForm.setData('departament', e.target.value)}
                                    placeholder="Ex: Recursos Humanos"
                                    required
                                />
                                {createForm.errors.departament && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.departament}</p>
                                )}
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, marginBottom: 12 }}>
                                <div>
                                    <label style={label} htmlFor="new-sigla">Sigla *</label>
                                    <input
                                        id="new-sigla"
                                        type="text"
                                        style={input}
                                        value={createForm.data.sigla}
                                        onChange={e => createForm.setData('sigla', e.target.value)}
                                        placeholder="Ex: RH"
                                        required
                                    />
                                    {createForm.errors.sigla && (
                                        <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.sigla}</p>
                                    )}
                                </div>
                                <div>
                                    <label style={label} htmlFor="new-code">Código</label>
                                    <input
                                        id="new-code"
                                        type="text"
                                        style={input}
                                        value={createForm.data.code}
                                        onChange={e => createForm.setData('code', e.target.value)}
                                        placeholder="Ex: RH-01"
                                    />
                                </div>
                            </div>

                            <div style={{ marginBottom: 12 }}>
                                <label style={label} htmlFor="new-unit">Secretaria / Unidade *</label>
                                <select
                                    id="new-unit"
                                    style={input}
                                    value={createForm.data.unit_id}
                                    onChange={e => createForm.setData('unit_id', e.target.value)}
                                    required
                                >
                                    {units.map(u => (
                                        <option key={u.id} value={u.id}>{u.name} ({u.sigla})</option>
                                    ))}
                                </select>
                                {createForm.errors.unit_id && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.unit_id}</p>
                                )}
                            </div>

                            <div style={{ marginBottom: 12 }}>
                                <label style={label} htmlFor="new-responsible">Responsável</label>
                                <input
                                    id="new-responsible"
                                    type="text"
                                    style={input}
                                    value={createForm.data.responsible}
                                    onChange={e => createForm.setData('responsible', e.target.value)}
                                    placeholder="Ex: João Silva"
                                />
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, marginBottom: 16 }}>
                                <div>
                                    <label style={label} htmlFor="new-phone">Telefone</label>
                                    <input
                                        id="new-phone"
                                        type="text"
                                        style={input}
                                        value={createForm.data.phone}
                                        onChange={e => createForm.setData('phone', e.target.value)}
                                        placeholder="Ex: 1199999999"
                                    />
                                </div>
                                <div>
                                    <label style={label} htmlFor="new-email">E-mail</label>
                                    <input
                                        id="new-email"
                                        type="email"
                                        style={input}
                                        value={createForm.data.email}
                                        onChange={e => createForm.setData('email', e.target.value)}
                                        placeholder="Ex: rh@exemplo.com"
                                    />
                                </div>
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
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>📋 Departamentos Cadastrados</h2>
                        <input
                            type="text"
                            placeholder="Buscar departamento..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ ...input, maxWidth: 240 }}
                        />
                    </div>

                    {filtered.length === 0 ? (
                        <div style={{ padding: 48, textAlign: 'center', color: '#64748b' }}>
                            <div style={{ fontSize: 36, marginBottom: 8 }}>🏢</div>
                            <p style={{ margin: 0 }}>Nenhum departamento encontrado.</p>
                        </div>
                    ) : (
                        <div style={{ overflowX: 'auto' }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a50' }}>
                                        {['Departamento', 'Sigla / Código', 'Unidade', 'Responsável', 'Contato', 'Ações'].map(h => (
                                            <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {filtered.map((dep, idx) => (
                                        <tr key={dep.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff02' }}>
                                            <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                                {editingId === dep.id ? (
                                                    <form onSubmit={e => handleUpdate(e, dep.id)} style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                                                        <input
                                                            type="text"
                                                            style={input}
                                                            value={editForm.data.departament}
                                                            onChange={e => editForm.setData('departament', e.target.value)}
                                                            placeholder="Nome"
                                                            autoFocus
                                                            required
                                                        />
                                                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 6 }}>
                                                            <input
                                                                type="text"
                                                                style={input}
                                                                value={editForm.data.sigla}
                                                                onChange={e => editForm.setData('sigla', e.target.value)}
                                                                placeholder="Sigla"
                                                                required
                                                            />
                                                            <input
                                                                type="text"
                                                                style={input}
                                                                value={editForm.data.code}
                                                                onChange={e => editForm.setData('code', e.target.value)}
                                                                placeholder="Código"
                                                            />
                                                        </div>
                                                        <select
                                                            style={input}
                                                            value={editForm.data.unit_id}
                                                            onChange={e => editForm.setData('unit_id', e.target.value)}
                                                            required
                                                        >
                                                            {units.map(u => (
                                                                <option key={u.id} value={u.id}>{u.sigla}</option>
                                                            ))}
                                                        </select>
                                                        <input
                                                            type="text"
                                                            style={input}
                                                            value={editForm.data.responsible}
                                                            onChange={e => editForm.setData('responsible', e.target.value)}
                                                            placeholder="Responsável"
                                                        />
                                                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 6 }}>
                                                            <input
                                                                type="text"
                                                                style={input}
                                                                value={editForm.data.phone}
                                                                onChange={e => editForm.setData('phone', e.target.value)}
                                                                placeholder="Telefone"
                                                            />
                                                            <input
                                                                type="email"
                                                                style={input}
                                                                value={editForm.data.email}
                                                                onChange={e => editForm.setData('email', e.target.value)}
                                                                placeholder="E-mail"
                                                            />
                                                        </div>
                                                        <div style={{ display: 'flex', gap: 6 }}>
                                                            <button type="submit" style={btnSave} disabled={editForm.processing}>✓</button>
                                                            <button type="button" style={btnCancel} onClick={() => setEditingId(null)}>✕</button>
                                                        </div>
                                                    </form>
                                                ) : (
                                                    dep.departament
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1' }}>
                                                {editingId !== dep.id && (
                                                    <>
                                                        <span style={{ fontWeight: 600 }}>{dep.sigla}</span>
                                                        {dep.code && <span style={{ display: 'block', fontSize: 12, color: '#64748b', marginTop: 2 }}>{dep.code}</span>}
                                                    </>
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#94a3b8' }}>
                                                {editingId !== dep.id && (dep.unit?.sigla ?? '—')}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1', fontSize: 13 }}>
                                                {editingId !== dep.id && (dep.responsible ?? '—')}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>
                                                {editingId !== dep.id && (
                                                    <>
                                                        <div>{dep.email}</div>
                                                        <div style={{ fontSize: 12, color: '#64748b' }}>{dep.phone}</div>
                                                    </>
                                                )}
                                            </td>
                                            <td style={{ padding: '12px 16px' }}>
                                                {editingId !== dep.id && (
                                                    <div style={{ display: 'flex', gap: 6 }}>
                                                        <button onClick={() => startEdit(dep)} style={btnEdit}>Editar</button>
                                                        <button onClick={() => handleDelete(dep.id)} style={btnDanger}>Excluir</button>
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
