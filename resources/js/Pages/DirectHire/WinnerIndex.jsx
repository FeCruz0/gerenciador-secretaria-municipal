import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function WinnerIndex({ people }) {
    const [search, setSearch] = useState('');

    const filtered = people.filter(p =>
        p.full_name?.toLowerCase().includes(search.toLowerCase()) ||
        p.social_name?.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <AdminLayout title="Vencedores de Contratações">
            <Head title="Vencedores" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Vencedores</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} pessoas cadastradas</p>
                </div>
                <Link href={route('contratacao_direta_vencedores.create')} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">+ Novo Vencedor</Link>
            </div>

            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar por nome..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ width: '100%', maxWidth: 400, padding: '8px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none' }}
                />
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155' }}>
                            {['Nome Completo', 'Nome Social', 'E-mail', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr><td colSpan={4} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma pessoa encontrada</td></tr>
                        ) : filtered.map(p => (
                            <tr key={p.id} style={{ borderBottom: '1px solid #1e293b' }}>
                                <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500 }}>{p.full_name}</td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{p.social_name || '—'}</td>
                                <td style={{ padding: '14px 16px', color: '#94a3b8' }}>{p.email || '—'}</td>
                                <td style={{ padding: '14px 16px' }}>
                                    <div style={{ display: 'flex', gap: 8 }}>
                                        <Link href={route('contratacao_direta_vencedores.show', p.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#94a3b8', fontSize: 12, textDecoration: 'none' }}>Ver Perfil</Link>
                                        <Link href={route('winner_itens', p.id)} style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#38bdf8', fontSize: 12, textDecoration: 'none' }}>Itens</Link>
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
