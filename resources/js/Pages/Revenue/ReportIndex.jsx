import React from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function RevenueReportIndex({ revenues, types }) {
    const totalValue = revenues.reduce((acc, r) => acc + (Number(r.value) || 0), 0);

    return (
        <AdminLayout title="Relatório de Receitas">
            <Head title="Relatório de Receitas" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Relatório de Receitas</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Gere relatórios em PDF por período e tipo</p>
                </div>
                <Link href={route('receitas.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Receitas</Link>
            </div>

            <div style={{ background: 'linear-gradient(135deg, #064e3b, #065f46)', borderRadius: 12, padding: '18px 24px', marginBottom: 24, display: 'flex', justifyContent: 'space-between', alignItems: 'center', border: '1px solid #10b98140' }}>
                <div>
                    <p style={{ color: '#6ee7b7', fontSize: 13, margin: '0 0 4px' }}>TOTAL CADASTRADO</p>
                    <p style={{ color: '#ecfdf5', fontSize: 24, margin: 0, fontWeight: 700 }}>R$ {totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>
                </div>
                <p style={{ color: '#6ee7b7', fontSize: 14, margin: 0 }}>{revenues.length} receitas</p>
            </div>

            <div style={{ background: '#1e293b', borderRadius: 12, padding: 28, border: '1px solid #334155' }}>
                <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Gerar Relatório PDF</h3>
                <form method="POST" action={route('report_revenues_pdf')}>
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
                            <label style={{ display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 }}>Tipo de Receita</label>
                            <select name="type_id" style={{ width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9' }}>
                                <option value="0">Todos</option>
                                {types.map(t => <option key={t.id} value={t.id}>{t.title}</option>)}
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
                    <button type="submit" className="btn-primary" style={{ padding: '10px 28px' }}>
                        📄 Gerar PDF
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
