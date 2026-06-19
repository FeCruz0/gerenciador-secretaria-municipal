import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function Create({ management_report_types = [], unit }) {
    const { data, setData, post, processing, errors } = useForm({
        management_report_type_id: '',
        status: 'DRAFT',
        initial_date: '',
        final_date: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('relatorio_de_gestao.store'));
    };

    const fieldStyle = {
        width: '100%', 
        padding: '10px 14px', 
        borderRadius: 8,
        border: '1px solid #334155', 
        background: '#0f172a',
        color: '#f1f5f9', 
        fontSize: 14, 
        boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title="Novo Relatório de Gestão">
            <Head title="Novo Relatório de Gestão" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Novo Relatório de Gestão</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Cadastre um novo relatório de gestão</p>
                </div>
                <Link href={route('relatorio_de_gestao.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit} style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', maxWidth: 800 }}>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
                    <div style={groupStyle}>
                        <label style={labelStyle}>Tipo de Relatório *</label>
                        <select 
                            value={data.management_report_type_id} 
                            onChange={e => setData('management_report_type_id', e.target.value)} 
                            style={fieldStyle} 
                            required
                        >
                            <option value="">Selecione...</option>
                            {management_report_types.map(type => (
                                <option key={type.id} value={type.id}>{type.type}</option>
                            ))}
                        </select>
                        {errors.management_report_type_id && <p style={errorStyle}>{errors.management_report_type_id}</p>}
                    </div>

                    <div style={groupStyle}>
                        <label style={labelStyle}>Status *</label>
                        <select 
                            value={data.status} 
                            onChange={e => setData('status', e.target.value)} 
                            style={fieldStyle} 
                            required
                        >
                            <option value="DRAFT">Desenvolvendo</option>
                            <option value="PENDING">Pendente</option>
                            <option value="PUBLISHED">Publicada</option>
                        </select>
                        {errors.status && <p style={errorStyle}>{errors.status}</p>}
                    </div>
                </div>

                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>
                    <div style={groupStyle}>
                        <label style={labelStyle}>Data Inicial *</label>
                        <input 
                            type="date" 
                            value={data.initial_date} 
                            onChange={e => setData('initial_date', e.target.value)} 
                            style={fieldStyle} 
                            required 
                        />
                        {errors.initial_date && <p style={errorStyle}>{errors.initial_date}</p>}
                    </div>

                    <div style={groupStyle}>
                        <label style={labelStyle}>Data Final *</label>
                        <input 
                            type="date" 
                            value={data.final_date} 
                            onChange={e => setData('final_date', e.target.value)} 
                            style={fieldStyle} 
                            required 
                        />
                        {errors.final_date && <p style={errorStyle}>{errors.final_date}</p>}
                    </div>
                </div>

                <p style={{ color: '#94a3b8', fontSize: 13, margin: '12px 0 24px' }}>
                    <span style={{ color: '#f87171', fontWeight: 600 }}>*</span> O campo para adicionar o arquivo do relatório de gestão irá aparecer logo após o cadastro.
                </p>

                <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('relatorio_de_gestao.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>Cancelar</Link>
                    <button 
                        type="submit" 
                        disabled={processing} 
                        className="btn-primary" 
                        style={{ opacity: processing ? 0.6 : 1 }}
                    >
                        {processing ? 'Cadastrando...' : 'Cadastrar'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
