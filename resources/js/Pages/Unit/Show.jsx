import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function UnitShow({ unit_selected, organizations, social_media }) {
    // Form 1: Edit Unit Details (uses POST + _method: 'PUT' for file uploads)
    const { data: unitData, setData: setUnitData, post: unitPost, processing: unitProcessing, errors: unitErrors } = useForm({
        _method: 'PUT',
        name: unit_selected.name || '',
        sigla: unit_selected.sigla || '',
        organization_id: unit_selected.organization_id || '',
        phone: unit_selected.phone || '',
        email: unit_selected.email || '',
        document: unit_selected.document || '',
        operation: unit_selected.operation || '',
        address: unit_selected.address || '',
        google_maps_link: unit_selected.google_maps_link || '',
        google_maps_iframe: unit_selected.google_maps_iframe || '',
        web: unit_selected.web ? '1' : '0',
        logo: null,
        icon: null,
    });

    // Form 2: Associate Social Media
    const { data: mediaData, setData: setMediaData, post: mediaPost, processing: mediaProcessing, errors: mediaErrors, reset: resetMedia } = useForm({
        unit_id: unit_selected.id,
        social_media_id: '',
        url: '',
    });

    // Form 3: About Unit (uses POST + _method: 'PUT' if exists, else POST)
    const aboutExists = !!unit_selected.about;
    const { data: aboutData, setData: setAboutData, post: aboutPost, processing: aboutProcessing, errors: aboutErrors } = useForm({
        _method: aboutExists ? 'PUT' : 'POST',
        unit_id: unit_selected.id,
        title: unit_selected.about?.title || '',
        sub_title: unit_selected.about?.sub_title || '',
        founded_at: unit_selected.about?.founded_at ? unit_selected.about.founded_at.substring(0, 10) : '',
        description: unit_selected.about?.description || '',
        content: unit_selected.about?.body || '',
        image: null,
        status: unit_selected.about?.status || '',
    });

    function handleUnitSubmit(e) {
        e.preventDefault();
        unitPost(route('unidades.update', unit_selected.id));
    }

    function handleMediaSubmit(e) {
        e.preventDefault();
        mediaPost(route('unidade_social_media_add'), {
            onSuccess: () => resetMedia('url', 'social_media_id')
        });
    }

    function handleDeleteMedia(pivotId) {
        if (confirm('Deseja remover este vínculo de mídia social?')) {
            Inertia.get(route('unidade_social_media_delete', pivotId));
        }
    }

    function handleAboutSubmit(e) {
        e.preventDefault();
        if (aboutExists) {
            aboutPost(route('sobres.update', unit_selected.about.id));
        } else {
            aboutPost(route('sobres.store'));
        }
    }

    function handleDeleteUnit() {
        if (confirm('Tem certeza que deseja excluir esta unidade?')) {
            Inertia.delete(route('unidades.destroy', unit_selected.id));
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
        <AdminLayout title="Editar Unidade">
            <Head title={`Editar Unidade - ${unit_selected.name}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Dados da Unidade</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>{unit_selected.name}</p>
                </div>
                <Link href={route('unidades.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1.2fr 0.8fr', gap: 24, alignItems: 'start' }}>
                {/* Formulário de Detalhes da Unidade */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Cadastro</h3>

                    <form onSubmit={handleUnitSubmit}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Unidade *</label>
                            <input type="text" value={unitData.name} onChange={e => setUnitData('name', e.target.value)} style={fieldStyle} required />
                            {unitErrors.name && <p style={errorStyle}>{unitErrors.name}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Sigla *</label>
                                <input type="text" value={unitData.sigla} onChange={e => setUnitData('sigla', e.target.value)} style={fieldStyle} required />
                                {unitErrors.sigla && <p style={errorStyle}>{unitErrors.sigla}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Unidade Principal? *</label>
                                <select value={unitData.web} onChange={e => setUnitData('web', e.target.value)} style={fieldStyle} required>
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                                {unitErrors.web && <p style={errorStyle}>{unitErrors.web}</p>}
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Organização *</label>
                                <select value={unitData.organization_id} onChange={e => setUnitData('organization_id', e.target.value)} style={fieldStyle} required>
                                    <option value="">Selecione...</option>
                                    {organizations.map(org => (
                                        <option key={org.id} value={org.id}>{org.title}</option>
                                    ))}
                                </select>
                                {unitErrors.organization_id && <p style={errorStyle}>{unitErrors.organization_id}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Telefone *</label>
                                <input type="text" value={unitData.phone} onChange={e => setUnitData('phone', e.target.value)} placeholder="(22) 99999-9999" style={fieldStyle} required />
                                {unitErrors.phone && <p style={errorStyle}>{unitErrors.phone}</p>}
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>E-mail *</label>
                                <input type="email" value={unitData.email} onChange={e => setUnitData('email', e.target.value)} style={fieldStyle} required />
                                {unitErrors.email && <p style={errorStyle}>{unitErrors.email}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>CNPJ *</label>
                                <input type="text" value={unitData.document} onChange={e => setUnitData('document', e.target.value)} placeholder="00.000.000/0000-00" style={fieldStyle} />
                                {unitErrors.document && <p style={errorStyle}>{unitErrors.document}</p>}
                            </div>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Horário de Funcionamento *</label>
                            <input type="text" value={unitData.operation} onChange={e => setUnitData('operation', e.target.value)} style={fieldStyle} required />
                            {unitErrors.operation && <p style={errorStyle}>{unitErrors.operation}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Endereço *</label>
                            <input type="text" value={unitData.address} onChange={e => setUnitData('address', e.target.value)} style={fieldStyle} required />
                            {unitErrors.address && <p style={errorStyle}>{unitErrors.address}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Link do Google Maps *</label>
                            <input type="url" value={unitData.google_maps_link} onChange={e => setUnitData('google_maps_link', e.target.value)} style={fieldStyle} required />
                            {unitErrors.google_maps_link && <p style={errorStyle}>{unitErrors.google_maps_link}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>IFrame do Google Maps (SRC) *</label>
                            <textarea value={unitData.google_maps_iframe} onChange={e => setUnitData('google_maps_iframe', e.target.value)} rows={3} style={fieldStyle} required />
                            {unitErrors.google_maps_iframe && <p style={errorStyle}>{unitErrors.google_maps_iframe}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Logo Atual</label>
                                {unit_selected.logo ? (
                                    <img src={`/storage/images/units/${unit_selected.logo}`} alt="Logo" style={{ width: '100%', maxHeight: 80, objectFit: 'contain', background: '#0f172a', padding: 8, borderRadius: 8, border: '1px solid #334155', marginBottom: 8 }} />
                                ) : <div style={{ color: '#64748b', fontSize: 13, marginBottom: 8 }}>Nenhuma imagem</div>}
                                <input type="file" onChange={e => setUnitData('logo', e.target.files[0])} style={fieldStyle} accept="image/*" />
                                {unitErrors.logo && <p style={errorStyle}>{unitErrors.logo}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Ícone Atual</label>
                                {unit_selected.icon ? (
                                    <img src={`/storage/images/units/${unit_selected.icon}`} alt="Icon" style={{ width: '100%', maxHeight: 80, objectFit: 'contain', background: '#0f172a', padding: 8, borderRadius: 8, border: '1px solid #334155', marginBottom: 8 }} />
                                ) : <div style={{ color: '#64748b', fontSize: 13, marginBottom: 8 }}>Nenhuma imagem</div>}
                                <input type="file" onChange={e => setUnitData('icon', e.target.files[0])} style={fieldStyle} accept="image/*" />
                                {unitErrors.icon && <p style={errorStyle}>{unitErrors.icon}</p>}
                            </div>
                        </div>

                        <div style={{ display: 'flex', gap: 12, marginTop: 16 }}>
                            <button type="submit" disabled={unitProcessing} className="btn-primary" style={{ flex: 1, opacity: unitProcessing ? 0.6 : 1 }}>
                                {unitProcessing ? 'Salvando...' : 'Editar Unidade'}
                            </button>
                            <button type="button" onClick={handleDeleteUnit} style={{ padding: '10px 18px', borderRadius: 8, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 14 }}>
                                Deletar
                            </button>
                        </div>
                    </form>
                </div>

                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    {/* Vincular Mídia Social */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Vincular Mídia Social</h3>

                        <form onSubmit={handleMediaSubmit}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Mídia Social *</label>
                                <select value={mediaData.social_media_id} onChange={e => setMediaData('social_media_id', e.target.value)} style={fieldStyle} required>
                                    <option value="">Selecione...</option>
                                    {social_media.map(m => (
                                        <option key={m.id} value={m.id}>{m.title}</option>
                                    ))}
                                </select>
                                {mediaErrors.social_media_id && <p style={errorStyle}>{mediaErrors.social_media_id}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>URL *</label>
                                <input type="url" value={mediaData.url} onChange={e => setMediaData('url', e.target.value)} placeholder="https://..." style={fieldStyle} required />
                                {mediaErrors.url && <p style={errorStyle}>{mediaErrors.url}</p>}
                            </div>

                            <button type="submit" disabled={mediaProcessing} className="btn-primary" style={{ width: '100%', opacity: mediaProcessing ? 0.6 : 1 }}>
                                {mediaProcessing ? 'Salvando...' : 'Vincular Mídia'}
                            </button>
                        </form>

                        {/* Mídias Vinculadas */}
                        <div style={{ overflow: 'hidden', borderRadius: 8, border: '1px solid #334155', marginTop: 20 }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#1e293b' }}>
                                        <th style={{ padding: '10px 14px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600 }}>Mídia</th>
                                        <th style={{ padding: '10px 14px', textAlign: 'left', color: '#94a3b8', fontSize: 12, fontWeight: 600 }}>URL</th>
                                        <th style={{ padding: '10px 14px', textAlign: 'right', color: '#94a3b8', fontSize: 12, fontWeight: 600 }}>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!unit_selected.social_media || unit_selected.social_media.length === 0 ? (
                                        <tr><td colSpan={3} style={{ padding: 20, textAlign: 'center', color: '#64748b', fontSize: 13 }}>Nenhuma mídia vinculada</td></tr>
                                    ) : unit_selected.social_media.map(m => (
                                        <tr key={m.pivot.id} style={{ borderBottom: '1px solid #334155' }}>
                                            <td style={{ padding: '10px 14px', color: '#f1f5f9', fontSize: 13 }}>{m.title}</td>
                                            <td style={{ padding: '10px 14px', color: '#94a3b8', fontSize: 12 }}>
                                                <a href={m.pivot.url} target="_blank" rel="noopener noreferrer" style={{ color: '#3b82f6', textDecoration: 'none' }}>Ver Link</a>
                                            </td>
                                            <td style={{ padding: '10px 14px', textAlign: 'right' }}>
                                                <button type="button" onClick={() => handleDeleteMedia(m.pivot.id)} style={{ padding: '4px 8px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 11 }}>Remover</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Formulário Sobre a Unidade */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Sobre a Unidade</h3>

                        <form onSubmit={handleAboutSubmit}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Título *</label>
                                <input type="text" value={aboutData.title} onChange={e => setAboutData('title', e.target.value)} style={fieldStyle} required />
                                {aboutErrors.title && <p style={errorStyle}>{aboutErrors.title}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Subtítulo *</label>
                                <input type="text" value={aboutData.sub_title} onChange={e => setAboutData('sub_title', e.target.value)} style={fieldStyle} required />
                                {aboutErrors.sub_title && <p style={errorStyle}>{aboutErrors.sub_title}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Data de Fundação</label>
                                <input type="date" value={aboutData.founded_at} onChange={e => setAboutData('founded_at', e.target.value)} style={fieldStyle} />
                                {aboutErrors.founded_at && <p style={errorStyle}>{aboutErrors.founded_at}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Descrição Geral *</label>
                                <textarea value={aboutData.description} onChange={e => setAboutData('description', e.target.value)} rows={3} style={fieldStyle} required />
                                {aboutErrors.description && <p style={errorStyle}>{aboutErrors.description}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Corpo de Conteúdo *</label>
                                <textarea value={aboutData.content} onChange={e => setAboutData('content', e.target.value)} rows={5} style={fieldStyle} required />
                                {aboutErrors.content && <p style={errorStyle}>{aboutErrors.content}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Status de Publicação *</label>
                                <select value={aboutData.status} onChange={e => setAboutData('status', e.target.value)} style={fieldStyle} required>
                                    <option value="">Selecione...</option>
                                    <option value="DRAFT">Desenvolvendo</option>
                                    <option value="PENDING">Pendente</option>
                                    <option value="PUBLISHED">Publicada</option>
                                </select>
                                {aboutErrors.status && <p style={errorStyle}>{aboutErrors.status}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Imagem Sobre a Unidade</label>
                                {unit_selected.about?.image && (
                                    <img src={`/storage/images/about/${unit_selected.about.image}`} alt="Sobre" style={{ width: '100%', maxHeight: 120, objectFit: 'cover', borderRadius: 8, border: '1px solid #334155', marginBottom: 8 }} />
                                )}
                                <input type="file" onChange={e => setAboutData('image', e.target.files[0])} style={fieldStyle} accept="image/*" />
                                {aboutErrors.image && <p style={errorStyle}>{aboutErrors.image}</p>}
                            </div>

                            <button type="submit" disabled={aboutProcessing} className="btn-primary" style={{ width: '100%', opacity: aboutProcessing ? 0.6 : 1 }}>
                                {aboutProcessing ? 'Salvando...' : 'Salvar Dados Sobre'}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
