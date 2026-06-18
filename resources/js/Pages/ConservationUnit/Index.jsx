import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ConservationUnitIndex({ conservation_units = [] }) {
    const [search, setSearch] = useState('');

    const filtered = conservation_units.filter(cu =>
        cu.title?.toLowerCase().includes(search.toLowerCase())
    );

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta Unidade de Conservação?')) {
            Inertia.delete(route('unid_conservacao.destroy', id));
        }
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const input = { padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', width: '100%', maxWidth: 300, boxSizing: 'border-box' };
    const btnPrimary  = { padding: '10px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14, textDecoration: 'none', display: 'inline-flex', alignItems: 'center' };
    const btnDanger   = { padding: '6px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 13 };
    const btnEdit     = { padding: '6px 12px', borderRadius: 6, background: '#1e3a5f', color: '#93c5fd', border: '1px solid #2563eb40', cursor: 'pointer', fontSize: 13, textDecoration: 'none', display: 'inline-block' };

    return (
        <AdminLayout title="Unidades de Conservação">
            <Head title="Unidades de Conservação" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Unidades de Conservação</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Administração · {conservation_units.length} unidade{conservation_units.length !== 1 ? 's' : ''} cadastrada{conservation_units.length !== 1 ? 's' : ''}
                    </p>
                </div>
                <Link href={route('unid_conservacao.create')} style={btnPrimary}>
                    ➕ Nova Unidade
                </Link>
            </div>

            <div style={{ ...card }}>
                {/* Filtro */}
                <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>📋 Unidades Cadastradas</h2>
                    <input
                        type="text"
                        placeholder="Buscar unidade..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={input}
                    />
                </div>

                {filtered.length === 0 ? (
                    <div style={{ padding: 64, textAlign: 'center', color: '#64748b' }}>
                        <div style={{ fontSize: 48, marginBottom: 12 }}>🌲</div>
                        <p style={{ margin: 0 }}>Nenhuma unidade de conservação encontrada.</p>
                    </div>
                ) : (
                    <div style={{ overflowX: 'auto' }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a50' }}>
                                    {['Unidade', 'Tipo', 'Área', 'Contato', 'Status', 'Ações'].map(h => (
                                        <th key={h} style={{ padding: '14px 20px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((cu, idx) => (
                                    <tr key={cu.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff02' }}>
                                        <td style={{ padding: '14px 20px', color: '#f1f5f9', fontWeight: 500 }}>
                                            <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
                                                {cu.thumb ? (
                                                    <img src={`/storage/${cu.thumb}`} alt="" style={{ width: 40, height: 40, borderRadius: 6, objectFit: 'cover', background: '#0f172a' }} />
                                                ) : (
                                                    <div style={{ width: 40, height: 40, borderRadius: 6, background: '#334155', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: 18 }}>🌳</div>
                                                )}
                                                <div>
                                                    <Link href={route('unid_conservacao.show', cu.id)} style={{ color: '#3b82f6', textDecoration: 'none', fontWeight: 600 }}>
                                                        {cu.title}
                                                    </Link>
                                                    <span style={{ display: 'block', fontSize: 12, color: '#64748b', marginTop: 2 }}>{cu.creation}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style={{ padding: '14px 20px', color: '#cbd5e1' }}>
                                            {cu.type?.type ?? '—'}
                                        </td>
                                        <td style={{ padding: '14px 20px', color: '#cbd5e1' }}>
                                            {cu.area}
                                        </td>
                                        <td style={{ padding: '14px 20px', color: '#94a3b8', fontSize: 13 }}>
                                            <div>{cu.email}</div>
                                            <div style={{ fontSize: 12, color: '#64748b' }}>{cu.phone}</div>
                                        </td>
                                        <td style={{ padding: '14px 20px' }}>
                                            <span style={{
                                                background: cu.status === 'PUBLISHED' ? '#065f4620' : '#7f1d1d20',
                                                color: cu.status === 'PUBLISHED' ? '#34d399' : '#f87171',
                                                border: cu.status === 'PUBLISHED' ? '1px solid #065f4660' : '1px solid #7f1d1d40',
                                                padding: '2px 8px',
                                                borderRadius: 6,
                                                fontSize: 12,
                                                fontWeight: 500
                                            }}>
                                                {cu.status === 'PUBLISHED' ? 'Publicado' : 'Rascunho'}
                                            </span>
                                        </td>
                                        <td style={{ padding: '14px 20px' }}>
                                            <div style={{ display: 'flex', gap: 8 }}>
                                                <Link href={route('unid_conservacao.show', cu.id)} style={btnEdit}>
                                                    Visualizar / Editar
                                                </Link>
                                                <button onClick={() => handleDelete(cu.id)} style={btnDanger}>
                                                    Excluir
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
        </AdminLayout>
    );
}
