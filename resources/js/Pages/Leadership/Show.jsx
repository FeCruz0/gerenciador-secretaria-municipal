import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function LeadershipShow({ leadership, social_media }) {
    // Form for editing leadership (uses _method: 'PUT' with POST for file uploads)
    const { data: editData, setData: setEditData, post: editPost, processing: editProcessing, errors: editErrors } = useForm({
        _method: 'PUT',
        name: leadership.name || '',
        occupation: leadership.occupation || '',
        order: leadership.order || '',
        photo: null,
        type: leadership.type || '',
        status: leadership.status || '',
    });

    // Form for adding a social media link
    const { data: mediaData, setData: setMediaData, post: mediaPost, processing: mediaProcessing, errors: mediaErrors, reset: resetMedia } = useForm({
        leadership_id: leadership.id,
        social_media_id: '',
        url: '',
    });

    function handleEditSubmit(e) {
        e.preventDefault();
        editPost(route('liderancas.update', leadership.id));
    }

    function handleMediaSubmit(e) {
        e.preventDefault();
        mediaPost(route('leadership_social_media_add'), {
            onSuccess: () => resetMedia('url', 'social_media_id')
        });
    }

    function handleDeleteMedia(pivotId) {
        if (confirm('Deseja remover este vínculo de mídia social?')) {
            Inertia.get(route('leadership_social_media_delete', pivotId));
        }
    }

    function handleDeleteLeadership() {
        if (confirm('Tem certeza que deseja excluir esta liderança?')) {
            Inertia.delete(route('liderancas.destroy', leadership.id));
        }
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
        <AdminLayout title="Editar Liderança">
            <Head title={`Editar Liderança - ${leadership.name}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Dados da Liderança</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{leadership.name}</p>
                </div>
                <Link href={route('liderancas.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24, alignItems: 'start' }}>
                {/* Painel de Edição de Dados */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Liderança</h3>
                    
                    <form onSubmit={handleEditSubmit}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome *</label>
                            <input 
                                type="text" 
                                value={editData.name} 
                                onChange={e => setEditData('name', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {editErrors.name && <p style={errorStyle}>{editErrors.name}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Ocupação *</label>
                            <input 
                                type="text" 
                                value={editData.occupation} 
                                onChange={e => setEditData('occupation', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {editErrors.occupation && <p style={errorStyle}>{editErrors.occupation}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Ordem *</label>
                            <input 
                                type="number" 
                                value={editData.order} 
                                onChange={e => setEditData('order', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {editErrors.order && <p style={errorStyle}>{editErrors.order}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Foto Atual</label>
                            {leadership.photo ? (
                                <img src={`/storage/images/leadership/${leadership.photo}`} alt={leadership.name} style={{ width: 100, height: 100, objectFit: 'cover', borderRadius: 8, border: '2px solid #334155', marginBottom: 10 }} />
                            ) : (
                                <div style={{ width: 100, height: 100, borderRadius: 8, background: '#334155', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#64748b', fontSize: 12, marginBottom: 10 }}>Sem foto</div>
                            )}
                            <input 
                                type="file" 
                                onChange={e => setEditData('photo', e.target.files[0])} 
                                style={fieldStyle} 
                                accept="image/*"
                            />
                            {editErrors.photo && <p style={errorStyle}>{editErrors.photo}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Tipo *</label>
                            <select 
                                value={editData.type} 
                                onChange={e => setEditData('type', e.target.value)} 
                                style={fieldStyle}
                                required
                            >
                                <option value="HEADSHIP">Chefia</option>
                                <option value="EMPLOYEE">Funcionário</option>
                            </select>
                            {editErrors.type && <p style={errorStyle}>{editErrors.type}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Status *</label>
                            <select 
                                value={editData.status} 
                                onChange={e => setEditData('status', e.target.value)} 
                                style={fieldStyle}
                                required
                            >
                                <option value="DRAFT">Desenvolvendo</option>
                                <option value="PENDING">Pendente</option>
                                <option value="PUBLISHED">Publicada</option>
                            </select>
                            {editErrors.status && <p style={errorStyle}>{editErrors.status}</p>}
                        </div>

                        <div style={{ display: 'flex', gap: 12 }}>
                            <button 
                                type="submit" 
                                disabled={editProcessing} 
                                className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                                style={{ flex: 1, opacity: editProcessing ? 0.6 : 1 }}
                            >
                                {editProcessing ? 'Salvando...' : 'Editar'}
                            </button>
                            <button 
                                type="button"
                                onClick={handleDeleteLeadership}
                                style={{ padding: '10px 18px', borderRadius: 8, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 14 }}
                            >
                                Deletar
                            </button>
                        </div>
                    </form>
                </div>

                {/* Seção Mídias Sociais */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    {/* Cadastrar Nova Mídia Social */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Vincular Mídia Social</h3>
                        
                        <form onSubmit={handleMediaSubmit}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Mídia Social</label>
                                <select 
                                    value={mediaData.social_media_id} 
                                    onChange={e => setMediaData('social_media_id', e.target.value)} 
                                    style={fieldStyle}
                                    required
                                >
                                    <option value="">Selecione...</option>
                                    {social_media.map(m => (
                                        <option key={m.id} value={m.id}>{m.title}</option>
                                    ))}
                                </select>
                                {mediaErrors.social_media_id && <p style={errorStyle}>{mediaErrors.social_media_id}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>URL</label>
                                <input 
                                    type="url" 
                                    value={mediaData.url} 
                                    onChange={e => setMediaData('url', e.target.value)} 
                                    placeholder="https://facebook.com/..." 
                                    style={fieldStyle} 
                                    required 
                                />
                                {mediaErrors.url && <p style={errorStyle}>{mediaErrors.url}</p>}
                            </div>

                            <button 
                                type="submit" 
                                disabled={mediaProcessing} 
                                className="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg px-4 py-2 font-medium shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                                style={{ width: '100%', opacity: mediaProcessing ? 0.6 : 1 }}
                            >
                                {mediaProcessing ? 'Salvando...' : 'Salvar Mídia'}
                            </button>
                        </form>
                    </div>

                    {/* Mídias Sociais Vinculadas */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Mídias Sociais Vinculadas</h3>

                        <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155' }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                        <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Mídia Social</th>
                                        <th style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>URL</th>
                                        <th style={{ padding: '12px 16px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600, textTransform: 'uppercase' }}>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!leadership.social_media || leadership.social_media.length === 0 ? (
                                        <tr><td colSpan={3} style={{ padding: 40, textAlign: 'center', color: '#64748b' }}>Nenhuma mídia vinculada</td></tr>
                                    ) : leadership.social_media.map(m => (
                                        <tr key={m.pivot.id} style={{ borderBottom: '1px solid #334155' }}>
                                            <td style={{ padding: '12px 16px', color: '#f1f5f9', fontWeight: 500 }}>{m.title}</td>
                                            <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 13 }}>
                                                <a href={m.pivot.url} target="_blank" rel="noopener noreferrer" style={{ color: '#3b82f6', textDecoration: 'none' }}>Ver link</a>
                                            </td>
                                            <td style={{ padding: '12px 16px', textAlign: 'right' }}>
                                                <button 
                                                    onClick={() => handleDeleteMedia(m.pivot.id)} 
                                                    style={{ padding: '4px 10px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 12 }}
                                                >
                                                    Remover
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
