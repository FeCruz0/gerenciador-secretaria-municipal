import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ExpenseIndex({ expenses }) {
    const [search, setSearch] = useState('');

    const list = Array.isArray(expenses) ? expenses : [];
    const filtered = list.filter(e =>
        e.title?.toLowerCase().includes(search.toLowerCase())
    );

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta despesa?')) {
            Inertia.delete(route('despesas.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280' };
        const color = map[status] || '#6b7280';
        return <span style={{ background: color + '20', color, padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{status || '—'}</span>;
    };

    const totalValue = list.reduce((acc, e) => acc + (Number(e.value) || 0), 0);

    return (
        <AdminLayout title="Despesas">
            <Head title="Despesas" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Despesas</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros</p>
                </div>
                <div style={{ display: 'flex', gap: 10 }}>
                    <Link href={route('relatorios.despesas')} style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>📊 Relatório</Link>
                    <Link href={route('despesas.create')} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">+ Nova Despesa</Link>
                </div>
            </div>

            {/* Summary Card */}
            <div style={{ background: 'linear-gradient(135deg, #7f1d1d, #991b1b)', borderRadius: 12, padding: '20px 24px', marginBottom: 20, border: '1px solid #ef444440', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <div>
                    <p style={{ color: '#fca5a5', fontSize: 13, margin: '0 0 4px', fontWeight: 500 }}>VALOR TOTAL CADASTRADO</p>
                    <p style={{ color: '#fff1f2', fontSize: 28, margin: 0, fontWeight: 700 }}>
                        R$ {totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}
                    </p>
                </div>
                <div style={{ fontSize: 40, opacity: 0.5 }}>📉</div>
            </div>

            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar despesa..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', maxWidth: 400, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155' }}>
                            {['Título', 'Tipo', 'Valor', 'Competência', 'Status', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr><td colSpan={6} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma despesa encontrada</td></tr>
                        ) : filtered.map(e => (
                            <tr key={e.id} style={{ borderBottom: '1px solid #1e293b' }} className="hover:bg-slate-800/50 transition-colors">
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500, maxWidth: 240 }}>
                                    <div style={{ overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{e.title}</div>
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{e.typeExpense?.title || e.type?.title || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#f87171', fontWeight: 700 }}>
                                    {e.value ? 'R$ ' + Number(e.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '—'}
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{e.competence || '—'}</td>
                                <td style={{ padding: '14px 16px' }}>{statusBadge(e.status)}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('despesas.show', e.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver</Link>
                                        <button onClick={() => handleDelete(e.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}>Excluir</button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
