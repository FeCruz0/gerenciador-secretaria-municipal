import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ExpenseTypeIndex({ type_expenses = [], type_selected = null }) {
    const [search, setSearch] = useState('');
    const [editingId, setEditingId] = useState(type_selected?.id ?? null);

    const filtered = type_expenses.filter(t =>
        t.title?.toLowerCase().includes(search.toLowerCase())
    );

    // ── Formulário de Cadastro ──
    const createForm = useForm({ title: '' });

    function handleCreate(e) {
        e.preventDefault();
        createForm.post(route('despesa_tipos.store'), {
            onSuccess: () => createForm.reset(),
        });
    }

    // ── Formulário de Edição ──
    const editForm = useForm({
        title: type_selected?.title ?? '',
    });

    function startEdit(type) {
        setEditingId(type.id);
        editForm.setData('title', type.title);
    }

    function handleUpdate(e, id) {
        e.preventDefault();
        editForm.put(route('despesa_tipos.update', id), {
            onSuccess: () => setEditingId(null),
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir este Tipo de Despesa?')) {
            Inertia.delete(route('despesa_tipos.destroy', id));
        }
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 6, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const btnPrimary  = { padding: '9px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnDanger   = { padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 12 };
    const btnEdit     = { padding: '5px 12px', borderRadius: 6, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40', cursor: 'pointer', fontSize: 12 };
    const btnSave     = { padding: '5px 12px', borderRadius: 6, background: '#065f4620', color: '#34d399', border: '1px solid #065f4660', cursor: 'pointer', fontSize: 12 };
    const btnCancel   = { padding: '5px 12px', borderRadius: 6, background: '#33415580', color: '#94a3b8', border: 'none', cursor: 'pointer', fontSize: 12 };

    return (
        <AdminLayout title="Tipos de Despesa">
            <Head title="Tipos de Despesa" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Tipos de Despesa</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Configuração · {type_expenses.length} tipo{type_expenses.length !== 1 ? 's' : ''} cadastrado{type_expenses.length !== 1 ? 's' : ''}
                    </p>
                </div>
                <Link
                    href={route('despesas.index')}
                    style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}
                >
                    ← Despesas
                </Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '340px 1fr', gap: 24, alignItems: 'start' }}>

                {/* ── Painel Esquerdo: Formulário de Cadastro ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>
                            ➕ Novo Tipo de Despesa
                        </h2>
                    </div>
                    <div style={{ padding: 20 }}>
                        <form onSubmit={handleCreate}>
                            <div style={{ marginBottom: 16 }}>
                                <label style={label} htmlFor="new-title">Nome</label>
                                <input
                                    id="new-title"
                                    type="text"
                                    style={input}
                                    value={createForm.data.title}
                                    onChange={e => createForm.setData('title', e.target.value)}
                                    placeholder="Ex: Despesa de Pessoal"
                                    required
                                />
                                {createForm.errors.title && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.title}</p>
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

                        {/* Resumo */}
                        <div style={{ marginTop: 24, padding: '12px 16px', background: '#0f172a', borderRadius: 8, border: '1px solid #1e293b' }}>
                            <p style={{ margin: 0, color: '#64748b', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Total de Tipos</p>
                            <p style={{ margin: '4px 0 0', color: '#f1f5f9', fontSize: 28, fontWeight: 700 }}>{type_expenses.length}</p>
                        </div>
                    </div>
                </div>

                {/* ── Painel Direito: Lista ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>📋 Tipos Cadastrados</h2>
                        <input
                            type="text"
                            placeholder="Buscar tipo..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ ...input, maxWidth: 240 }}
                        />
                    </div>

                    {filtered.length === 0 ? (
                        <div style={{ padding: 48, textAlign: 'center', color: '#64748b' }}>
                            <div style={{ fontSize: 36, marginBottom: 8 }}>💸</div>
                            <p style={{ margin: 0 }}>Nenhum tipo de despesa encontrado.</p>
                        </div>
                    ) : (
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155' }}>
                                    {['Tipo de Despesa', 'Despesas', 'Criado em', 'Ações'].map(h => (
                                        <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((type, idx) => (
                                    <tr key={type.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff05' }}>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                            {editingId === type.id ? (
                                                <form onSubmit={e => handleUpdate(e, type.id)} style={{ display: 'flex', gap: 8 }}>
                                                    <input
                                                        type="text"
                                                        style={{ ...input, flex: 1 }}
                                                        value={editForm.data.title}
                                                        onChange={e => editForm.setData('title', e.target.value)}
                                                        autoFocus
                                                        required
                                                     />
                                                    <button type="submit" style={btnSave} disabled={editForm.processing}>✓</button>
                                                    <button type="button" style={btnCancel} onClick={() => setEditingId(null)}>✕</button>
                                                </form>
                                            ) : (
                                                type.title
                                            )}
                                        </td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8' }}>
                                            <span style={{ background: '#1e3a5f', color: '#93c5fd', padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>
                                                {type.expenses?.length ?? 0}
                                            </span>
                                        </td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>
                                            {type.created_at ? new Date(type.created_at).toLocaleDateString('pt-BR') : '—'}
                                        </td>
                                        <td style={{ padding: '12px 16px' }}>
                                            {editingId !== type.id && (
                                                <div style={{ display: 'flex', gap: 8 }}>
                                                    <button onClick={() => startEdit(type)} style={btnEdit}>Editar</button>
                                                    <button onClick={() => handleDelete(type.id)} style={btnDanger}>Excluir</button>
                                                </div>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
