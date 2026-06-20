import React from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LegislationReportIndex({ legislations, categories, situations }) {
    return (
        <AdminLayout title="Relatório de Legislações">
            <Head title="Relatório de Legislações" />
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Relatório de Legislações</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Gere relatórios em PDF por período e filtros</p>
                </div>
                <Link href={route('legislacoes.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Legislações</Link>
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, padding: 28, border: '1px solid #334155' }}>
                <form method="POST" action={route('report_legislations_pdf')}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16, marginBottom: 20 }}>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Tipo de Período</label>
                            <select name="type" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}>
                                <option value="day">Diário</option>
                                <option value="month">Mensal</option>
                                <option value="year">Anual</option>
                                <option value="between">Intervalo</option>
                            </select>
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Categoria</label>
                            <select name="category_id" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}>
                                <option value="0">Todas</option>
                                {categories.map(c => <option key={c.id} value={c.id}>{c.category}</option>)}
                            </select>
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Situação</label>
                            <select name="situation_id" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}>
                                <option value="0">Todas</option>
                                {situations.map(s => <option key={s.id} value={s.id}>{s.situation}</option>)}
                            </select>
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Dia</label>
                            <input type="date" name="day" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', boxSizing: 'border-box' }} />
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Mês</label>
                            <input type="number" name="month" min="1" max="12" placeholder="01-12" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', boxSizing: 'border-box' }} />
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Ano</label>
                            <input type="number" name="year" defaultValue={new Date().getFullYear()} style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', boxSizing: 'border-box' }} />
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Data Início</label>
                            <input type="date" name="date_start" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', boxSizing: 'border-box' }} />
                        </div>
                        <div>
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Data Fim</label>
                            <input type="date" name="date_end" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', boxSizing: 'border-box' }} />
                        </div>
                    </div>
                    <button type="submit" className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ padding: '10px 28px' }}>
                        📄 Gerar PDF
                    </button>
                </form>

                <div style={{ marginTop: 32, borderTop: '1px solid #334155', paddingTop: 24 }}>
                    <p style={{ color: '#64748b', marginBottom: 12 }}>Total cadastrado: <strong style={{ color: '#f1f5f9' }}>{legislations.length}</strong> legislações</p>
                </div>
            </div>
        </AdminLayout>
    );
}
