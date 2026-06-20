import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function WinnerCreate({ genres, matrial_statuses, countries, states, cities }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        full_name: '',
        social_name: '',
        genre_id: '',
        marital_status_id: '',
        birth_date: '',
        nationality: 'Brasileira',
        naturalness_country_id: '',
        naturalness_state_id: '',
        naturalness_city_id: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('contratacao_direta_vencedores.store'), { onSuccess: () => reset() });
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title="Novo Vencedor">
            <Head title="Novo Vencedor" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Novo Vencedor</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Cadastre os dados pessoais do vencedor</p>
                </div>
                <Link href={route('contratacao_direta_vencedores.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
                        <div>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Dados de Identificação</h3>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Nome Completo *</label>
                                <input type="text" value={data.full_name} onChange={e => setData('full_name', e.target.value)} style={fieldStyle} required />
                                {errors.full_name && <p style={errorStyle}>{errors.full_name}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Nome Social</label>
                                <input type="text" value={data.social_name} onChange={e => setData('social_name', e.target.value)} style={fieldStyle} />
                                {errors.social_name && <p style={errorStyle}>{errors.social_name}</p>}
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Gênero</label>
                                    <select value={data.genre_id} onChange={e => setData('genre_id', e.target.value)} style={fieldStyle}>
                                        <option value="">Selecione...</option>
                                        {genres.map(g => <option key={g.id} value={g.id}>{g.title}</option>)}
                                    </select>
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Estado Civil</label>
                                    <select value={data.marital_status_id} onChange={e => setData('marital_status_id', e.target.value)} style={fieldStyle}>
                                        <option value="">Selecione...</option>
                                        {matrial_statuses.map(ms => <option key={ms.id} value={ms.id}>{ms.title}</option>)}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Nascimento e Nacionalidade</h3>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Data de Nascimento</label>
                                <input type="date" value={data.birth_date} onChange={e => setData('birth_date', e.target.value)} style={fieldStyle} />
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Nacionalidade</label>
                                <input type="text" value={data.nationality} onChange={e => setData('nationality', e.target.value)} style={fieldStyle} />
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>País</label>
                                    <select value={data.naturalness_country_id} onChange={e => setData('naturalness_country_id', e.target.value)} style={fieldStyle}>
                                        <option value="">Selecione...</option>
                                        {countries.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                                    </select>
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Estado</label>
                                    <select value={data.naturalness_state_id} onChange={e => setData('naturalness_state_id', e.target.value)} style={fieldStyle}>
                                        <option value="">Selecione...</option>
                                        {states.map(s => <option key={s.id} value={s.id}>{s.title}</option>)}
                                    </select>
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Cidade</label>
                                    <select value={data.naturalness_city_id} onChange={e => setData('naturalness_city_id', e.target.value)} style={fieldStyle}>
                                        <option value="">Selecione...</option>
                                        {cities.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('contratacao_direta_vencedores.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>Cancelar</Link>
                    <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Vencedor'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
