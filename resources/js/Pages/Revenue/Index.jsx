import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function RevenueIndex({ revenues }) {
    const [search, setSearch] = useState('');

    const filtered = revenues.filter(r =>
        r.title?.toLowerCase().includes(search.toLowerCase()) ||
        r.description?.toLowerCase().includes(search.toLowerCase())
    );

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta receita?')) {
            Inertia.delete(route('receitas.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280' };
        const color = map[status] || '#6b7280';
        return <span style={{ background: color + '20', color, padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{status || '—'}</span>;
    };

    const totalValue = revenues.reduce((acc, r) => acc + (Number(r.value) || 0), 0);

    return (
        <AdminLayout title="Receitas">
            <Head title="Receitas" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Receitas</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros</p>
                </div>
                <div style={{ display: 'flex', gap: 10 }}>
                    <Link href={route('relatorios.receitas')} style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>📊 Relatório</Link>
                    <Link href={route('receitas.create')} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">+ Nova Receita</Link>
                </div>
            </div>

            {/* Summary Card */}
            <div style={{ background: 'linear-gradient(135deg, #064e3b, #065f46)', borderRadius: 12, padding: '20px 24px', marginBottom: 20, border: '1px solid #10b981' + '40', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <div>
                    <p style={{ color: '#6ee7b7', fontSize: 13, margin: '0 0 4px', fontWeight: 500 }}>VALOR TOTAL CADASTRADO</p>
                    <p style={{ color: '#ecfdf5', fontSize: 28, margin: 0, fontWeight: 700 }}>
                        R$ {totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}
                    </p>
                </div>
                <div style={{ fontSize: 40, opacity: 0.5 }}>💰</div>
            </div>

            {/* Search */}
            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar receita..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', maxWidth: 400, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
            </div>

            {/* Table */}
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
                            <tr><td colSpan={6} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma receita encontrada</td></tr>
                        ) : filtered.map(r => (
                            <tr key={r.id} style={{ borderBottom: '1px solid #1e293b' }} className="hover:bg-slate-800/50 transition-colors">
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500, maxWidth: 240 }}>
                                    <div style={{ overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{r.title}</div>
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{r.type?.title || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#10b981', fontWeight: 700 }}>
                                    {r.value ? 'R$ ' + Number(r.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '—'}
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{r.competence || '—'}</td>
                                <td style={{ padding: '14px 16px' }}>{statusBadge(r.status)}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('receitas.show', r.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver</Link>
                                        <button onClick={() => handleDelete(r.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}>Excluir</button>
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
