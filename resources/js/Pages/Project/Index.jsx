import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ProjectIndex({ projects }) {
    const [search, setSearch] = useState('');

    const filtered = projects.filter(p =>
        p.title?.toLowerCase().includes(search.toLowerCase())
    );

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir este projeto?')) {
            Inertia.delete(route('projetos.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', PENDING: '#3b82f6' };
        const color = map[status] || '#6b7280';
        return <span style={{ background: color + '20', color, padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{status}</span>;
    };

    return (
        <AdminLayout title="Projetos">
            <Head title="Projetos" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Projetos</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros</p>
                </div>
                <div style={{ display: 'flex', gap: 12 }}>
                    <Link href={route('projeto_categorias.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Categorias</Link>
                    <Link href={route('projetos.create')} className="btn-primary">+ Novo Projeto</Link>
                </div>
            </div>

            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar por título..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', maxWidth: 400, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155' }}>
                            {['Imagem', 'Título', 'Categoria', 'Status', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr><td colSpan={5} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhum projeto encontrado</td></tr>
                        ) : filtered.map(p => (
                            <tr key={p.id} style={{ borderBottom: '1px solid #1e293b' }}>
                                <td style={{ padding: '14px 16px' }}>
                                    {p.path ? (
                                        <img src={`/storage/images/projects/${p.path}`} alt={p.title} style={{ width: 50, height: 35, objectFit: 'cover', borderRadius: 4 }} />
                                    ) : (
                                        <div style={{ width: 50, height: 35, background: '#334155', borderRadius: 4, display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#64748b', fontSize: 10 }}>Sem foto</div>
                                    )}
                                </td>
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500 }}>{p.title}</td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{p.category?.title || '—'}</td>
                                <td style={{ padding: '14px 16px' }}>{statusBadge(p.status)}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('projetos.show', p.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver / Editar</Link>
                                        <button onClick={() => handleDelete(p.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}>Excluir</button>
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
