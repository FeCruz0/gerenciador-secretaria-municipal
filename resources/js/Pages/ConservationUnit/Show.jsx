import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ConservationUnitShow({ conservation_unit, coverages = [], types = [] }) {
    const { data, setData, post, processing, errors } = useForm({
        _method: 'PUT',
        title: conservation_unit.title ?? '',
        conservation_unit_type_id: conservation_unit.conservation_unit_type_id ?? '',
        creation: conservation_unit.creation ?? '',
        creation_link: conservation_unit.creation_link ?? '',
        objective: conservation_unit.objective ?? '',
        area: conservation_unit.area ?? '',
        localization: conservation_unit.localization ?? '',
        address: conservation_unit.address ?? '',
        phone: conservation_unit.phone ?? '',
        email: conservation_unit.email ?? '',
        opening_hours: conservation_unit.opening_hours ?? '',
        thumb: null,
        thumb_description: conservation_unit.thumb_description ?? '',
        status: conservation_unit.status ?? 'DRAFT',
        coverages: conservation_unit.coverages?.map(c => c.id) ?? [],
    });

    function handleSubmit(e) {
        e.preventDefault();
        // Simulação de PUT via POST para suporte a upload de arquivo
        post(route('unid_conservacao.update', conservation_unit.id));
    }

    function handleCoverageChange(id) {
        const isChecked = data.coverages.includes(id);
        if (isChecked) {
            setData('coverages', data.coverages.filter(c => c !== id));
        } else {
            setData('coverages', [...data.coverages, id]);
        }
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', padding: 24 };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 6, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '10px 14px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const textarea = { ...input, height: 100, resize: 'vertical' };
    const btnPrimary  = { padding: '10px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnCancel   = { padding: '10px 20px', borderRadius: 8, background: '#33415580', color: '#94a3b8', border: 'none', cursor: 'pointer', fontSize: 14, textDecoration: 'none', display: 'inline-block' };

    return (
        <AdminLayout title={conservation_unit.title}>
            <Head title={conservation_unit.title} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>{conservation_unit.title}</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>Detalhes e Edição da Unidade de Conservação</p>
                </div>
                <Link href={route('unid_conservacao.index')} style={btnCancel}>
                    Voltar
                </Link>
            </div>

            <div style={card}>
                <form onSubmit={handleSubmit} encType="multipart/form-data">
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20, marginBottom: 20 }}>
                        <div>
                            <label style={label} htmlFor="title">Título / Nome da Unidade *</label>
                            <input id="title" type="text" style={input} value={data.title} onChange={e => setData('title', e.target.value)} required />
                            {errors.title && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.title}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="type">Tipo de Unidade *</label>
                            <select id="type" style={input} value={data.conservation_unit_type_id} onChange={e => setData('conservation_unit_type_id', e.target.value)} required>
                                {types.map(t => (
                                    <option key={t.id} value={t.id}>{t.type}</option>
                                ))}
                            </select>
                            {errors.conservation_unit_type_id && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.conservation_unit_type_id}</p>}
                        </div>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20, marginBottom: 20 }}>
                        <div>
                            <label style={label} htmlFor="creation">Ato de Criação *</label>
                            <input id="creation" type="text" style={input} value={data.creation} onChange={e => setData('creation', e.target.value)} required />
                            {errors.creation && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.creation}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="creation_link">Link do Ato de Criação *</label>
                            <input id="creation_link" type="url" style={input} value={data.creation_link} onChange={e => setData('creation_link', e.target.value)} required />
                            {errors.creation_link && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.creation_link}</p>}
                        </div>
                    </div>

                    <div style={{ marginBottom: 20 }}>
                        <label style={label} htmlFor="objective">Objetivo da Área</label>
                        <textarea id="objective" style={textarea} value={data.objective} onChange={e => setData('objective', e.target.value)} />
                        {errors.objective && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.objective}</p>}
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 20, marginBottom: 20 }}>
                        <div>
                            <label style={label} htmlFor="area">Área *</label>
                            <input id="area" type="text" style={input} value={data.area} onChange={e => setData('area', e.target.value)} required />
                            {errors.area && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.area}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="localization">Localização (Coordenadas) *</label>
                            <input id="localization" type="text" style={input} value={data.localization} onChange={e => setData('localization', e.target.value)} required />
                            {errors.localization && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.localization}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="status">Status de Publicação</label>
                            <select id="status" style={input} value={data.status} onChange={e => setData('status', e.target.value)}>
                                <option value="DRAFT">Rascunho</option>
                                <option value="PUBLISHED">Publicado</option>
                            </select>
                        </div>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 20, marginBottom: 20 }}>
                        <div>
                            <label style={label} htmlFor="address">Endereço *</label>
                            <input id="address" type="text" style={input} value={data.address} onChange={e => setData('address', e.target.value)} required />
                            {errors.address && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.address}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="phone">Telefone *</label>
                            <input id="phone" type="text" style={input} value={data.phone} onChange={e => setData('phone', e.target.value)} required />
                            {errors.phone && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.phone}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="email">E-mail *</label>
                            <input id="email" type="email" style={input} value={data.email} onChange={e => setData('email', e.target.value)} required />
                            {errors.email && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.email}</p>}
                        </div>
                    </div>

                    <div style={{ marginBottom: 20 }}>
                        <label style={label} htmlFor="opening_hours">Horário de Funcionamento *</label>
                        <input id="opening_hours" type="text" style={input} value={data.opening_hours} onChange={e => setData('opening_hours', e.target.value)} required />
                        {errors.opening_hours && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.opening_hours}</p>}
                    </div>

                    {/* Checkboxes de Coberturas */}
                    <div style={{ marginBottom: 24 }}>
                        <label style={label}>Coberturas</label>
                        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(200px, 1fr))', gap: 10, padding: 14, background: '#0f172a', borderRadius: 8, border: '1px solid #334155' }}>
                            {coverages.map(c => (
                                <label key={c.id} style={{ display: 'flex', alignItems: 'center', gap: 8, color: '#cbd5e1', fontSize: 14, cursor: 'pointer' }}>
                                    <input
                                        type="checkbox"
                                        checked={data.coverages.includes(c.id)}
                                        onChange={() => handleCoverageChange(c.id)}
                                        style={{ accentColor: '#2563eb' }}
                                    />
                                    {c.city}
                                </label>
                            ))}
                        </div>
                    </div>

                    {/* Upload do Thumb */}
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20, marginBottom: 28, padding: 20, background: '#0f172a50', borderRadius: 8, border: '1px solid #33415550' }}>
                        <div>
                            <label style={label} htmlFor="thumb">Alterar Foto de Capa</label>
                            {conservation_unit.thumb && (
                                <div style={{ marginBottom: 10 }}>
                                    <img src={`/storage/${conservation_unit.thumb}`} alt="" style={{ width: 100, height: 60, borderRadius: 6, objectFit: 'cover' }} />
                                    <span style={{ display: 'block', fontSize: 11, color: '#64748b', marginTop: 2 }}>Foto atual</span>
                                </div>
                            )}
                            <input id="thumb" type="file" onChange={e => setData('thumb', e.target.files[0])} style={{ color: '#94a3b8' }} />
                            {errors.thumb && <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{errors.thumb}</p>}
                        </div>

                        <div>
                            <label style={label} htmlFor="thumb_description">Descrição da Imagem</label>
                            <input id="thumb_description" type="text" style={input} value={data.thumb_description} onChange={e => setData('thumb_description', e.target.value)} />
                        </div>
                    </div>

                    <div style={{ display: 'flex', gap: 12 }}>
                        <button type="submit" style={btnPrimary} disabled={processing}>
                            {processing ? 'Salvando…' : 'Salvar Alterações'}
                        </button>
                        <Link href={route('unid_conservacao.index')} style={{ ...btnCancel, background: 'transparent' }}>
                            Cancelar
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
