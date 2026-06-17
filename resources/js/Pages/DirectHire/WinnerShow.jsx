import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function WinnerShow({ person, genres, matrial_statuses, countries, states, cities, directs_hires_winner }) {
    const { data, setData, put, processing, errors } = useForm({
        full_name: person.full_name || '',
        social_name: person.social_name || '',
        genre_id: person.genre_id || '',
        marital_status_id: person.marital_status_id || '',
        birth_date: person.birth_date ? person.birth_date.substring(0, 10) : '',
        nationality: person.nationality || 'Brasileira',
        naturalness_country_id: person.naturalness_country_id || '',
        naturalness_state_id: person.naturalness_state_id || '',
        naturalness_city_id: person.naturalness_city_id || '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        put(route('contratacao_direta_vencedores.update', person.id));
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
        <AdminLayout title={`Perfil de ${person.full_name}`}>
            <Head title={`Perfil: ${person.full_name}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Perfil do Vencedor</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Gerencie as informações pessoais</p>
                </div>
                <Link href={route('contratacao_direta_vencedores.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 24 }}>
                <form onSubmit={handleSubmit}>
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
                            <div>
                                <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Identificação</h3>

                                <div style={groupStyle}>
                                    <label style={labelStyle}>Nome Completo *</label>
                                    <input type="text" value={data.full_name} onChange={e => setData('full_name', e.target.value)} style={fieldStyle} required />
                                    {errors.full_name && <p style={errorStyle}>{errors.full_name}</p>}
                                </div>

                                <div style={groupStyle}>
                                    <label style={labelStyle}>Nome Social</label>
                                    <input type="text" value={data.social_name} onChange={e => setData('social_name', e.target.value)} style={fieldStyle} />
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
                                <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Nascimento</h3>

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

                        <div style={{ display: 'flex', justifyContent: 'flex-end', marginTop: 20 }}>
                            <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                                {processing ? 'Salvando...' : 'Salvar Alterações'}
                            </button>
                        </div>
                    </div>
                </form>

                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Contratações Ganhas</h3>
                    {directs_hires_winner?.length === 0 ? (
                        <p style={{ color: '#64748b', fontSize: 13 }}>Nenhuma contratação vinculada a esta pessoa.</p>
                    ) : (
                        <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
                            {directs_hires_winner.map(dhw => (
                                <div key={dhw.id} style={{ padding: 12, background: '#0f172a', borderRadius: 8, border: '1px solid #334155' }}>
                                    <div style={{ color: '#f1f5f9', fontSize: 13, fontWeight: 600 }}>Contratação ID: {dhw.direct_hire_id}</div>
                                    <div style={{ color: '#64748b', fontSize: 11, marginTop: 4 }}>Registrado em: {new Date(dhw.created_at).toLocaleDateString('pt-BR')}</div>
                                    <div style={{ marginTop: 8, display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                        <Link href={route('contratacoes_diretas.show', dhw.direct_hire_id)} style={{ fontSize: 12, color: '#38bdf8', textDecoration: 'none' }}>Ver Contratação →</Link>
                                        <Link href={route('contratacao_direta_vencedores.destroy', dhw.id)} method="delete" as="button" type="button" style={{ border: 'none', background: 'none', color: '#f87171', fontSize: 12, cursor: 'pointer' }}>Remover</Link>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
