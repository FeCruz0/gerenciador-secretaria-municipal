import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function UnitIndex({ units, organizations }) {
    const [search, setSearch] = useState('');

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        sigla: '',
        organization_id: '',
        phone: '',
        email: '',
        document: '',
        operation: '',
        address: '',
        google_maps_link: '',
        google_maps_iframe: '',
        web: '0',
        logo: null,
        icon: null,
    });

    const filtered = units.filter(u =>
        u.name?.toLowerCase().includes(search.toLowerCase()) ||
        u.sigla?.toLowerCase().includes(search.toLowerCase())
    );

    function handleSubmit(e) {
        e.preventDefault();
        post(route('unidades.store'), {
            onSuccess: () => reset()
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta unidade?')) {
            Inertia.delete(route('unidades.destroy', id));
        }
    }

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 16 };

    return (
        <AdminLayout title="Unidades">
            <Head title="Unidades" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Unidades</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{units.length} unidades cadastradas</p>
                </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: 24 }}>
                {/* Painel de Cadastro */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', height: 'fit-content' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Nova Unidade</h3>

                    <form onSubmit={handleSubmit}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome *</label>
                            <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} style={fieldStyle} required />
                            {errors.name && <p style={errorStyle}>{errors.name}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Sigla *</label>
                            <input type="text" value={data.sigla} onChange={e => setData('sigla', e.target.value)} style={fieldStyle} required />
                            {errors.sigla && <p style={errorStyle}>{errors.sigla}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Organização *</label>
                            <select value={data.organization_id} onChange={e => setData('organization_id', e.target.value)} style={fieldStyle} required>
                                <option value="">Selecione...</option>
                                {organizations.map(org => (
                                    <option key={org.id} value={org.id}>{org.title}</option>
                                ))}
                            </select>
                            {errors.organization_id && <p style={errorStyle}>{errors.organization_id}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Telefone *</label>
                            <input type="text" value={data.phone} onChange={e => setData('phone', e.target.value)} placeholder="(22) 99999-9999" style={fieldStyle} required />
                            {errors.phone && <p style={errorStyle}>{errors.phone}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>E-mail *</label>
                            <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} style={fieldStyle} required />
                            {errors.email && <p style={errorStyle}>{errors.email}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>CNPJ *</label>
                            <input type="text" value={data.document} onChange={e => setData('document', e.target.value)} placeholder="00.000.000/0000-00" style={fieldStyle} />
                            {errors.document && <p style={errorStyle}>{errors.document}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Horário de Funcionamento *</label>
                            <input type="text" value={data.operation} onChange={e => setData('operation', e.target.value)} placeholder="Segunda a Sexta de 8h às 17h" style={fieldStyle} required />
                            {errors.operation && <p style={errorStyle}>{errors.operation}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Endereço *</label>
                            <input type="text" value={data.address} onChange={e => setData('address', e.target.value)} style={fieldStyle} required />
                            {errors.address && <p style={errorStyle}>{errors.address}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Link Google Maps *</label>
                            <input type="url" value={data.google_maps_link} onChange={e => setData('google_maps_link', e.target.value)} style={fieldStyle} required />
                            {errors.google_maps_link && <p style={errorStyle}>{errors.google_maps_link}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>IFrame Google Maps (SRC) *</label>
                            <textarea value={data.google_maps_iframe} onChange={e => setData('google_maps_iframe', e.target.value)} rows={3} style={fieldStyle} required />
                            {errors.google_maps_iframe && <p style={errorStyle}>{errors.google_maps_iframe}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Unidade Principal? *</label>
                            <select value={data.web} onChange={e => setData('web', e.target.value)} style={fieldStyle} required>
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                            {errors.web && <p style={errorStyle}>{errors.web}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Imagem da Logo</label>
                            <input type="file" onChange={e => setData('logo', e.target.files[0])} style={fieldStyle} accept="image/*" />
                            {errors.logo && <p style={errorStyle}>{errors.logo}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Imagem do Ícone</label>
                            <input type="file" onChange={e => setData('icon', e.target.files[0])} style={fieldStyle} accept="image/*" />
                            {errors.icon && <p style={errorStyle}>{errors.icon}</p>}
                        </div>

                        <button type="submit" disabled={processing} className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" style={{ width: '100%', opacity: processing ? 0.6 : 1 }}>
                            {processing ? 'Salvando...' : 'Salvar Unidade'}
                        </button>
                    </form>
                </div>

                {/* Listagem */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', height: 'fit-content' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, margin: 0 }}>Unidades Existentes</h3>
                        <input
                            type="text"
                            placeholder="Buscar unidade..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ padding: '6px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none', fontSize: 13, width: 220 }}
                        />
                    </div>

                    <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155' }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Nome</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Sigla</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Principal</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Organização</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.length === 0 ? (
                                    <tr><td colSpan={5} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma unidade encontrada</td></tr>
                                ) : filtered.map(u => (
                                    <tr key={u.id} style={{ borderBottom: '1px solid #334155' }}>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>{u.name}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{u.sigla}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{u.web ? 'Sim' : 'Não'}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{u.organization?.title || '—'}</td>
                                        <td style={{ padding: '12px 16px', textAlign: 'right' }}>
                                            <div style={{ display: 'flex', gap: 8, justifyContent: 'flex-end' }}>
                                                <Link 
                                                    href={route('unidades.show', u.id)} 
                                                    style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#f1f5f9', fontSize: 12, textDecoration: 'none', display: 'inline-block' }}
                                                >
                                                    Editar
                                                </Link>
                                                <button 
                                                    onClick={() => handleDelete(u.id)} 
                                                    style={{ padding: '5px 12px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}
                                                >
                                                    Excluir
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
