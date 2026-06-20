import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LegislationCreate({ categories, situations, authors, subjects, units }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        number: '',
        year: new Date().getFullYear(),
        ementa: '',
        category_id: '',
        situation_id: '',
        author_id: '',
        unit_id: '',
        subjects: [],
        status: 'DRAFT',
        date: '',
        content: '',
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route('legislacoes.store'), { onSuccess: () => reset() });
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
        <AdminLayout title="Nova Legislação">
            <Head title="Nova Legislação" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Nova Legislação</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Preencha os campos abaixo para cadastrar</p>
                </div>
                <Link href={route('legislacoes.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>
                    ← Voltar
                </Link>
            </div>

            <form onSubmit={handleSubmit}>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24 }}>
                    {/* Left Column */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Informações Básicas</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Título *</label>
                            <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                            {errors.title && <p style={errorStyle}>{errors.title}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Número</label>
                                <input type="text" value={data.number} onChange={e => setData('number', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Ano</label>
                                <input type="number" value={data.year} onChange={e => setData('year', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data</label>
                            <input type="date" value={data.date} onChange={e => setData('date', e.target.value)} style={fieldStyle} />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status</label>
                            <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                <option value="DRAFT">Rascunho</option>
                                <option value="PUBLISHED">Publicado</option>
                                <option value="ARCHIVED">Arquivado</option>
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Ementa *</label>
                            <textarea value={data.ementa} onChange={e => setData('ementa', e.target.value)} rows={5} style={{ ...fieldStyle, resize: 'vertical' }} required />
                            {errors.ementa && <p style={errorStyle}>{errors.ementa}</p>}
                        </div>
                    </div>

                    {/* Right Column */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Classificação</h3>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Categoria</label>
                            <select value={data.category_id} onChange={e => setData('category_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {categories.map(c => <option key={c.id} value={c.id}>{c.category}</option>)}
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Situação</label>
                            <select value={data.situation_id} onChange={e => setData('situation_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {situations.map(s => <option key={s.id} value={s.id}>{s.situation}</option>)}
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Autor</label>
                            <select value={data.author_id} onChange={e => setData('author_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {authors.map(a => <option key={a.id} value={a.id}>{a.name || a.full_name}</option>)}
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Unidade</label>
                            <select value={data.unit_id} onChange={e => setData('unit_id', e.target.value)} style={fieldStyle}>
                                <option value="">Selecione...</option>
                                {units.map(u => <option key={u.id} value={u.id}>{u.name || u.title}</option>)}
                            </select>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Assuntos</label>
                            <select multiple value={data.subjects} onChange={e => setData('subjects', Array.from(e.target.selectedOptions, o => o.value))} style={{ ...fieldStyle, height: 120 }}>
                                {subjects.map(s => <option key={s.id} value={s.id}>{s.subject}</option>)}
                            </select>
                            <p style={{ color: '#64748b', fontSize: 12, marginTop: 4 }}>Segure Ctrl para selecionar múltiplos</p>
                        </div>
                    </div>
                </div>

                <div style={{ marginTop: 24, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                    <Link href={route('legislacoes.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>
                        Cancelar
                    </Link>
                    <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ opacity: processing ? 0.6 : 1 }}>
                        {processing ? 'Salvando...' : 'Salvar Legislação'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
