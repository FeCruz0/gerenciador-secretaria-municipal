import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function BiddingIndex({ biddings }) {
    const [search, setSearch] = useState('');

    const filtered = biddings.filter(b =>
        b.title?.toLowerCase().includes(search.toLowerCase()) ||
        b.number?.toLowerCase().includes(search.toLowerCase())
    );

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta licitação?')) {
            Inertia.delete(route('licitacoes.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', ARCHIVED: '#6b7280', OPEN: '#3b82f6', CLOSED: '#ef4444' };
        const color = map[status] || '#6b7280';
        return <span style={{ background: color + '20', color, padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{status}</span>;
    };

    return (
        <AdminLayout title="Licitações">
            <Head title="Licitações" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Licitações</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros</p>
                </div>
                <Link href={route('licitacoes.create')} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">+ Nova Licitação</Link>
            </div>

            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar por título ou número..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', maxWidth: 400, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155' }}>
                            {['Número', 'Título', 'Modalidade', 'Valor', 'Status', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr><td colSpan={6} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma licitação encontrada</td></tr>
                        ) : filtered.map(b => (
                            <tr key={b.id} style={{ borderBottom: '1px solid #1e293b' }} className="hover:bg-slate-800/50 transition-colors">
                                <td style={{ padding: '14px 16px', color: '#94a3b8', fontFamily: 'monospace' }}>{b.number || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500, maxWidth: 260 }}>
                                    <div style={{ overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{b.title}</div>
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{b.modality?.title || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#10b981', fontWeight: 600 }}>
                                    {b.value ? 'R$ ' + Number(b.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '—'}
                                </td>
                                <td style={{ padding: '14px 16px' }}>{statusBadge(b.status)}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('licitacoes.show', b.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver</Link>
                                        <button onClick={() => handleDelete(b.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}>Excluir</button>
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
