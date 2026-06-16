import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LegislationIndex({ legislations, categories, situations }) {
    const [search, setSearch] = useState('');
    const [filterCategory, setFilterCategory] = useState('');
    const [filterSituation, setFilterSituation] = useState('');

    const filtered = legislations.filter(l => {
        const matchSearch = l.title?.toLowerCase().includes(search.toLowerCase()) ||
            l.number?.toLowerCase().includes(search.toLowerCase());
        const matchCat = !filterCategory || l.category_id == filterCategory;
        const matchSit = !filterSituation || l.situation_id == filterSituation;
        return matchSearch && matchCat && matchSit;
    });

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta legislação?')) {
            Inertia.delete(route('legislacoes.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = {
            PUBLISHED: { label: 'Publicado', color: '#10b981' },
            DRAFT: { label: 'Rascunho', color: '#f59e0b' },
            ARCHIVED: { label: 'Arquivado', color: '#6b7280' },
        };
        const s = map[status] || { label: status, color: '#6b7280' };
        return (
            <span style={{
                background: s.color + '20', color: s.color,
                padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600
            }}>{s.label}</span>
        );
    };

    return (
        <AdminLayout title="Legislações">
            <Head title="Legislações" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Legislações</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros encontrados</p>
                </div>
                <Link href={route('legislacoes.create')} className="btn-primary">
                    + Nova Legislação
                </Link>
            </div>

            {/* Filters */}
            <div style={{ display: 'flex', gap: 12, marginBottom: 20, flexWrap: 'wrap' }}>
                <input
                    type="text"
                    placeholder="Buscar por título ou número..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ flex: 1, minWidth: 200, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
                <select
                    value={filterCategory}
                    onChange={e => setFilterCategory(e.target.value)}
                    style={{ padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}
                >
                    <option value="">Todas as categorias</option>
                    {categories.map(c => <option key={c.id} value={c.id}>{c.category}</option>)}
                </select>
                <select
                    value={filterSituation}
                    onChange={e => setFilterSituation(e.target.value)}
                    style={{ padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}
                >
                    <option value="">Todas as situações</option>
                    {situations.map(s => <option key={s.id} value={s.id}>{s.situation}</option>)}
                </select>
            </div>

            {/* Table */}
            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155' }}>
                            {['Número', 'Título', 'Categoria', 'Situação', 'Status', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr><td colSpan={6} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhum resultado encontrado</td></tr>
                        ) : filtered.map(l => (
                            <tr key={l.id} style={{ borderBottom: '1px solid #1e293b' }} className="table-row-hover">
                                <td style={{ padding: '14px 16px', color: '#94a3b8', fontFamily: 'monospace' }}>{l.number || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500, maxWidth: 280 }}>
                                    <div style={{ overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>{l.title}</div>
                                </td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{l.category?.category || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{l.situation?.situation || '—'}</td>
                                <td style={{ padding: '14px 16px' }}>{statusBadge(l.status)}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('legislacoes.show', l.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver</Link>
                                        <button onClick={() => handleDelete(l.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}>Excluir</button>
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
