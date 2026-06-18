import React, { useState } from 'react';
import { Head } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function HiringReportsIndex({
    direct_hires,
    direct_hire_modalities,
    direct_hire_situations,
    direct_hire_winners,
    bidding_modalities,
    bidding_situations,
    biddings,
    agreement_origins,
    agreement_types,
    agreement_situations,
    agreements,
}) {
    const [dhType, setDhType] = useState('day');
    const [agType, setAgType] = useState('day');
    const [bdType, setBdType] = useState('day');

    // ─── Styles ────────────────────────────────────────────────────────────────
    const card = {
        background: '#1e293b',
        borderRadius: 12,
        padding: 24,
        border: '1px solid #334155',
    };
    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const groupStyle = { marginBottom: 16 };
    const sectionTitle = { color: '#f1f5f9', fontSize: 16, fontWeight: 700, marginTop: 0, marginBottom: 20, borderBottom: '1px solid #334155', paddingBottom: 12 };
    const btnPrimary = {
        padding: '10px 20px', borderRadius: 8, background: '#3b82f6',
        color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14,
    };
    const btnReset = {
        padding: '10px 20px', borderRadius: 8, background: '#334155',
        color: '#94a3b8', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14,
    };

    // ─── Stat Card ──────────────────────────────────────────────────────────────
    const StatCard = ({ label, count, color }) => (
        <div style={{ background: '#1e293b', borderRadius: 12, padding: '20px 24px', border: `1px solid ${color}30`, display: 'flex', alignItems: 'center', gap: 16 }}>
            <div style={{ width: 48, height: 48, borderRadius: 12, background: color + '20', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: 22 }}>
                📋
            </div>
            <div>
                <div style={{ fontSize: 28, fontWeight: 700, color: '#f1f5f9' }}>{count}</div>
                <div style={{ fontSize: 13, color: '#94a3b8', marginTop: 2 }}>{label}</div>
            </div>
        </div>
    );

    // ─── Date fields per type ──────────────────────────────────────────────────
    const DateFields = ({ prefix, type }) => {
        if (type === 'day') return (
            <div style={groupStyle}>
                <label style={labelStyle}>Dia</label>
                <input type="date" name={`${prefix}_day`} style={fieldStyle} />
            </div>
        );
        if (type === 'month') return (
            <>
                <div style={groupStyle}>
                    <label style={labelStyle}>Mês</label>
                    <select name={`${prefix}_month`} style={fieldStyle}>
                        {['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'].map((m, i) => (
                            <option key={i} value={i+1}>{m}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Ano</label>
                    <input type="text" name={`${prefix}_year`} placeholder="2024" style={fieldStyle} />
                </div>
            </>
        );
        if (type === 'year') return (
            <div style={groupStyle}>
                <label style={labelStyle}>Ano</label>
                <input type="text" name={`${prefix}_year`} placeholder="2024" style={fieldStyle} />
            </div>
        );
        if (type === 'between') return (
            <>
                <div style={groupStyle}>
                    <label style={labelStyle}>Data de Início</label>
                    <input type="date" name={`${prefix}_date_start`} style={fieldStyle} />
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Data Final</label>
                    <input type="date" name={`${prefix}_date_end`} style={fieldStyle} />
                </div>
            </>
        );
        return null;
    };

    // ─── Report Form ────────────────────────────────────────────────────────────
    const ReportForm = ({ title, action, prefix, type, setType, children }) => (
        <div style={{ ...card, marginBottom: 24 }}>
            <h3 style={sectionTitle}>{title}</h3>
            <form method="POST" action={action} target="_blank">
                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                <div style={groupStyle}>
                    <label style={labelStyle}>Tipo de Data</label>
                    <select name={`${prefix}_type`} style={fieldStyle} value={type} onChange={e => setType(e.target.value)}>
                        <option value="day">Diário</option>
                        <option value="month">Mensal</option>
                        <option value="year">Anual</option>
                        <option value="between">Escolher Datas</option>
                    </select>
                </div>

                {children}

                <DateFields prefix={prefix} type={type} />

                <div style={{ display: 'flex', gap: 10, marginTop: 20 }}>
                    <button type="submit" style={btnPrimary}>Gerar PDF</button>
                    <button type="reset" onClick={() => setType('day')} style={btnReset}>Resetar</button>
                </div>
            </form>
        </div>
    );

    return (
        <AdminLayout title="Relatórios de Contratação">
            <Head title="Relatórios de Contratação" />

            {/* Page Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>
                        Relatórios de Contratação
                    </h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>
                        Gere relatórios em PDF por período e filtros
                    </p>
                </div>
            </div>

            {/* Stats */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16, marginBottom: 32 }}>
                <StatCard label="Contratações Diretas" count={direct_hires.length} color="#3b82f6" />
                <StatCard label="Contratos" count={agreements.length} color="#10b981" />
                <StatCard label="Licitações" count={biddings.length} color="#f59e0b" />
            </div>

            {/* Form 1: Contratações Diretas */}
            <ReportForm
                title="📄 Contratações Diretas"
                action="/report_direct_hires_pdf"
                prefix="direct_hire"
                type={dhType}
                setType={setDhType}
            >
                <div style={groupStyle}>
                    <label style={labelStyle}>Vencedores</label>
                    <select name="direct_hire_winner_id" style={fieldStyle}>
                        <option value="">Todos</option>
                        {direct_hire_winners.map(w => (
                            <option key={w.id} value={w.id}>{w.full_name}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Modalidades</label>
                    <select name="direct_hire_modality_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {direct_hire_modalities.map(m => (
                            <option key={m.id} value={m.id}>{m.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Situações</label>
                    <select name="direct_hire_situation_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {direct_hire_situations.map(s => (
                            <option key={s.id} value={s.id}>{s.title}</option>
                        ))}
                    </select>
                </div>
            </ReportForm>

            {/* Form 2: Contratos */}
            <ReportForm
                title="📑 Contratos"
                action="/report_agreements_pdf"
                prefix="agreement"
                type={agType}
                setType={setAgType}
            >
                <div style={groupStyle}>
                    <label style={labelStyle}>Licitações</label>
                    <select name="agreement_bidding_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {biddings.map(b => (
                            <option key={b.id} value={b.id}>{b.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Origens</label>
                    <select name="agreement_origin_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {agreement_origins.map(o => (
                            <option key={o.id} value={o.id}>{o.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Tipos</label>
                    <select name="agreement_type_id" style={fieldStyle}>
                        <option value="">Todos</option>
                        {agreement_types.map(t => (
                            <option key={t.id} value={t.id}>{t.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Situações</label>
                    <select name="agreement_situation_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {agreement_situations.map(s => (
                            <option key={s.id} value={s.id}>{s.title}</option>
                        ))}
                    </select>
                </div>
            </ReportForm>

            {/* Form 3: Licitações */}
            <ReportForm
                title="🏛️ Licitações"
                action="/report_biddings_pdf"
                prefix="bidding"
                type={bdType}
                setType={setBdType}
            >
                <div style={groupStyle}>
                    <label style={labelStyle}>Licitações</label>
                    <select name="bidding_bidding_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {biddings.map(b => (
                            <option key={b.id} value={b.id}>{b.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Modalidades</label>
                    <select name="bidding_modality_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {bidding_modalities.map(m => (
                            <option key={m.id} value={m.id}>{m.title}</option>
                        ))}
                    </select>
                </div>
                <div style={groupStyle}>
                    <label style={labelStyle}>Situações</label>
                    <select name="bidding_situation_id" style={fieldStyle}>
                        <option value="">Todas</option>
                        {bidding_situations.map(s => (
                            <option key={s.id} value={s.id}>{s.title}</option>
                        ))}
                    </select>
                </div>
            </ReportForm>
        </AdminLayout>
    );
}
