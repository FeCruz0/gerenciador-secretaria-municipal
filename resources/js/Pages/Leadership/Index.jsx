import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LeadershipIndex({ leaderships }) {
    const [search, setSearch] = useState('');
    
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        occupation: '',
        order: '',
        photo: null,
        type: '',
        status: '',
    });

    const filtered = leaderships.filter(l =>
        l.name?.toLowerCase().includes(search.toLowerCase())
    );

    function handleSubmit(e) {
        e.preventDefault();
        
        // Since we are sending a file, we use a multipart form data post
        post(route('liderancas.store'), {
            onSuccess: () => reset()
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta liderança?')) {
            Inertia.delete(route('liderancas.destroy', id));
        }
    }

    const statusBadge = (status) => {
        const map = { PUBLISHED: '#10b981', DRAFT: '#f59e0b', PENDING: '#3b82f6' };
        const labelMap = { PUBLISHED: 'Publicada', DRAFT: 'Desenvolvendo', PENDING: 'Pendente' };
        const color = map[status] || '#6b7280';
        return <span style={{ background: color + '20', color, padding: '2px 10px', borderRadius: 20, fontSize: 12, fontWeight: 600 }}>{labelMap[status] || status}</span>;
    };

    const typeLabel = (type) => {
        const map = { HEADSHIP: 'Chefia', EMPLOYEE: 'Funcionário' };
        return map[type] || type;
    };

    const fieldStyle = {
        width: '100%', padding: '10px 14px', borderRadius: 8,
        border: '1px solid #334155', background: '#0f172a',
        color: '#f1f5f9', fontSize: 14, boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title="Lideranças">
            <Head title="Lideranças" />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Lideranças</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{leaderships.length} registros cadastrados</p>
                </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr', gap: 24 }}>
                {/* Cadastrar Nova Liderança */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', height: 'fit-content' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Nova Liderança</h3>
                    
                    <form onSubmit={handleSubmit}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome *</label>
                            <input 
                                type="text" 
                                value={data.name} 
                                onChange={e => setData('name', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {errors.name && <p style={errorStyle}>{errors.name}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Ocupação *</label>
                            <input 
                                type="text" 
                                value={data.occupation} 
                                onChange={e => setData('occupation', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {errors.occupation && <p style={errorStyle}>{errors.occupation}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Ordem *</label>
                            <input 
                                type="number" 
                                value={data.order} 
                                onChange={e => setData('order', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {errors.order && <p style={errorStyle}>{errors.order}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Foto *</label>
                            <input 
                                type="file" 
                                onChange={e => setData('photo', e.target.files[0])} 
                                style={fieldStyle} 
                                accept="image/*"
                                required 
                            />
                            {errors.photo && <p style={errorStyle}>{errors.photo}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Tipo *</label>
                            <select 
                                value={data.type} 
                                onChange={e => setData('type', e.target.value)} 
                                style={fieldStyle}
                                required
                            >
                                <option value="">Selecione...</option>
                                <option value="HEADSHIP">Chefia</option>
                                <option value="EMPLOYEE">Funcionário</option>
                            </select>
                            {errors.type && <p style={errorStyle}>{errors.type}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status *</label>
                            <select 
                                value={data.status} 
                                onChange={e => setData('status', e.target.value)} 
                                style={fieldStyle}
                                required
                            >
                                <option value="">Selecione...</option>
                                <option value="DRAFT">Desenvolvendo</option>
                                <option value="PENDING">Pendente</option>
                                <option value="PUBLISHED">Publicada</option>
                            </select>
                            {errors.status && <p style={errorStyle}>{errors.status}</p>}
                        </div>

                        <button 
                            type="submit" 
                            disabled={processing} 
                            className="btn-primary" 
                            style={{ width: '100%', opacity: processing ? 0.6 : 1 }}
                        >
                            {processing ? 'Salvando...' : 'Salvar Liderança'}
                        </button>
                    </form>
                </div>

                {/* Listagem de Lideranças */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, margin: 0 }}>Lideranças Existentes</h3>
                        <input
                            type="text"
                            placeholder="Buscar liderança..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ padding: '6px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', outline: 'none', fontSize: 13, width: 220 }}
                        />
                    </div>

                    <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155' }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Foto</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Nome</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ocupação</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ordem</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Tipo</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Status</th>
                                    <th style={{ padding: '12px 16px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.length === 0 ? (
                                    <tr><td colSpan={7} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma liderança encontrada</td></tr>
                                ) : filtered.map(l => (
                                    <tr key={l.id} style={{ borderBottom: '1px solid #334155' }}>
                                        <td style={{ padding: '12px 16px' }}>
                                            {l.photo ? (
                                                <img src={`/storage/images/leadership/${l.photo}`} alt={l.name} style={{ width: 40, height: 40, objectFit: 'cover', borderRadius: '50%', border: '2px solid #334155' }} />
                                            ) : (
                                                <div style={{ width: 40, height: 40, borderRadius: '50%', background: '#334155', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#64748b', fontSize: 10 }}>Sem foto</div>
                                            )}
                                        </td>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>{l.name}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{l.occupation}</td>
                                        <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>{l.order}</td>
                                        <td style={{ padding: '12px 16px', color: '#f1f5f9', fontSize: 13 }}>{typeLabel(l.type)}</td>
                                        <td style={{ padding: '12px 16px' }}>{statusBadge(l.status)}</td>
                                        <td style={{ padding: '12px 16px', textAlign: 'right' }}>
                                            <div style={{ display: 'flex', gap: 8, justifyContent: 'flex-end' }}>
                                                <Link 
                                                    href={route('liderancas.show', l.id)} 
                                                    style={{ padding: '5px 12px', borderRadius: 6, background: '#334155', color: '#f1f5f9', fontSize: 12, textDecoration: 'none', display: 'inline-block' }}
                                                >
                                                    Editar
                                                </Link>
                                                <button 
                                                    onClick={() => handleDelete(l.id)} 
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
