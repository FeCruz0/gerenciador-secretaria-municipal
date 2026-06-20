import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function Index({ management_reports = [], unit }) {
    const [search, setSearch] = useState('');

    const formatDate = (dateStr, includeTime = false) => {
        if (!dateStr) return '—';
        try {
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return dateStr;
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            if (includeTime) {
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
            }
            return `${day}/${month}/${year}`;
        } catch (e) {
            return dateStr;
        }
    };

    const getStatusLabelAndColor = (status) => {
        switch (status) {
            case 'PUBLISHED':
                return { label: 'Publicado', color: '#10b981' };
            case 'PENDING':
                return { label: 'Pendente', color: '#3b82f6' };
            case 'DRAFT':
            default:
                return { label: 'Desenvolvendo', color: '#f59e0b' };
        }
    };

    const statusBadge = (status) => {
        const { label, color } = getStatusLabelAndColor(status);
        return (
            <span style={{ 
                background: color + '20', 
                color, 
                padding: '4px 10px', 
                borderRadius: 20, 
                fontSize: 12, 
                fontWeight: 600 
            }}>
                {label}
            </span>
        );
    };

    const filtered = management_reports.filter(report => {
        const typeName = report.management_report_type?.type || '';
        return typeName.toLowerCase().includes(search.toLowerCase());
    });

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este Relatório de Gestão?')) {
            Inertia.delete(route('relatorio_de_gestao.destroy', id));
        }
    };

    return (
        <AdminLayout title="Relatório de Gestão">
            <Head title="Relatórios de Gestão" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Relatórios de Gestão</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{filtered.length} registros</p>
                </div>
                <div>
                    <Link href={route('relatorio_de_gestao.create')} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none">+ Novo Relatório</Link>
                </div>
            </div>

            {/* Contadores */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: 16, marginBottom: 24 }}>
                <div style={{ background: '#1e293b', border: '1px solid #334155', borderRadius: 12, padding: 20, display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <div>
                        <h3 style={{ fontSize: 28, fontWeight: 800, color: '#f1f5f9', margin: 0 }}>{management_reports.length}</h3>
                        <span style={{ color: '#94a3b8', fontSize: 13, fontWeight: 500 }}>Total de Relatórios de Gestão</span>
                    </div>
                </div>
                <div style={{ background: '#1e293b', border: '1px solid #334155', borderRadius: 12, padding: 20, display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <div>
                        <h3 style={{ fontSize: 28, fontWeight: 800, color: '#10b981', margin: 0 }}>{management_reports.filter(r => r.status === 'PUBLISHED').length}</h3>
                        <span style={{ color: '#94a3b8', fontSize: 13, fontWeight: 500 }}>Total de Publicados</span>
                    </div>
                </div>
            </div>

            {/* Barra de pesquisa */}
            <div style={{ marginBottom: 16 }}>
                <input
                    type="text"
                    placeholder="Buscar por tipo de relatório..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                    style={{ 
                        width: '100%', 
                        maxWidth: 400, 
                        padding: '10px 14px', 
                        borderRadius: 8, 
                        border: '1px solid #334155', 
                        background: '#0f172a', 
                        color: '#f1f5f9', 
                        outline: 'none' 
                    }}
                />
            </div>

            {/* Tabela */}
            <div style={{ background: '#1e293b', borderRadius: 12, overflow: 'hidden', border: '1px solid #334155' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a' }}>
                            {['Data Inicial', 'Período', 'Data Final', 'Status', 'Data de criação', 'Ações'].map(h => (
                                <th key={h} style={{ padding: '14px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {filtered.length === 0 ? (
                            <tr>
                                <td colSpan={6} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>
                                    Nenhum relatório de gestão encontrado
                                </td>
                            </tr>
                        ) : (
                            filtered.map(report => (
                                <tr key={report.id} style={{ borderBottom: '1px solid #334155' }}>
                                    <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                        {formatDate(report.initial_date)}
                                    </td>
                                    <td style={{ padding: '14px 16px', color: '#94a3b8' }}>
                                        {report.management_report_type?.type || '—'}
                                    </td>
                                    <td style={{ padding: '14px 16px', color: '#f1f5f9', fontWeight: 500 }}>
                                        {formatDate(report.final_date)}
                                    </td>
                                    <td style={{ padding: '14px 16px' }}>
                                        {statusBadge(report.status)}
                                    </td>
                                    <td style={{ padding: '14px 16px', color: '#94a3b8' }}>
                                        {formatDate(report.created_at, true)}
                                    </td>
                                    <td style={{ padding: '14px 16px' }}>
                                        <div style={{ display: 'flex', gap: 8 }}>
                                            <Link 
                                                href={route('relatorio_de_gestao.show', report.id)} 
                                                style={{ 
                                                    padding: '6px 12px', 
                                                    borderRadius: 6, 
                                                    background: '#334155', 
                                                    color: '#94a3b8', 
                                                    fontSize: 12, 
                                                    textDecoration: 'none',
                                                    fontWeight: 500
                                                }}
                                            >
                                                Ver / Editar
                                            </Link>
                                            <button 
                                                onClick={() => handleDelete(report.id)} 
                                                style={{ 
                                                    padding: '6px 12px', 
                                                    borderRadius: 6, 
                                                    background: '#7f1d1d20', 
                                                    color: '#f87171', 
                                                    border: 'none', 
                                                    cursor: 'pointer', 
                                                    fontSize: 12,
                                                    fontWeight: 500
                                                }}
                                            >
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
