import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function ProjectShow({ project, project_files, categories }) {
    const { data, setData, post, processing, errors } = useForm({
        title: project.title || '',
        category_id: project.category_id || '',
        status: project.status || 'DRAFT',
        content: project.content || '',
        thumb: null,
        _method: 'PUT', // Forçar POST com método PUT para suportar uploads
    });

    const [files, setFiles] = useState([]);
    const [fileTitles, setFileTitles] = useState(['']);

    const handleUpdate = (e) => {
        e.preventDefault();
        post(route('projetos.update', project.id));
    };

    const handleDelete = () => {
        if (confirm('Tem certeza que deseja excluir este projeto?')) {
            Inertia.delete(route('projetos.destroy', project.id));
        }
    };

    const handleAddFileInput = () => {
        setFiles([...files, null]);
        setFileTitles([...fileTitles, '']);
    };

    const handleRemoveFileInput = (index) => {
        const newFiles = [...files];
        newFiles.splice(index, 1);
        setFiles(newFiles);

        const newTitles = [...fileTitles];
        newTitles.splice(index, 1);
        setFileTitles(newTitles);
    };

    const handleUploadFiles = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('type', 'project');
        formData.append('id', project.id);

        let hasFiles = false;
        const fileInputs = document.querySelectorAll('input[type="file"].project-file-input');
        fileInputs.forEach((input, index) => {
            if (input.files[0]) {
                formData.append(`files[document][${index}]`, input.files[0]);
                formData.append(`files[title][${index}]`, fileTitles[index] || input.files[0].name);
                hasFiles = true;
            }
        });

        if (!hasFiles) {
            alert('Selecione pelo menos um arquivo.');
            return;
        }

        Inertia.post(route('arquivos.store'), formData, {
            onSuccess: () => {
                setFiles([]);
                setFileTitles(['']);
            }
        });
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
        <AdminLayout title={`Editar Projeto - ${project.title}`}>
            <Head title={`Editar: ${project.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Detalhes do Projeto</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Gerencie as informações do projeto e seus anexos</p>
                </div>
                <Link href={route('projetos.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 24 }}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    {/* Formulário Principal */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Conteúdo</h3>
                        <form onSubmit={handleUpdate}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Título do Projeto *</label>
                                <input type="text" value={data.title} onChange={e => setData('title', e.target.value)} style={fieldStyle} required />
                                {errors.title && <p style={errorStyle}>{errors.title}</p>}
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Descrição / Detalhes</label>
                                <textarea value={data.content} onChange={e => setData('content', e.target.value)} rows={10} style={{ ...fieldStyle, resize: 'vertical' }} />
                                {errors.content && <p style={errorStyle}>{errors.content}</p>}
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Categoria *</label>
                                    <select value={data.category_id} onChange={e => setData('category_id', e.target.value)} style={fieldStyle} required>
                                        <option value="">Selecione...</option>
                                        {categories.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                                    </select>
                                </div>
                                <div style={groupStyle}>
                                    <label style={labelStyle}>Status</label>
                                    <select value={data.status} onChange={e => setData('status', e.target.value)} style={fieldStyle}>
                                        <option value="DRAFT">Rascunho</option>
                                        <option value="PENDING">Pendente</option>
                                        <option value="PUBLISHED">Publicado</option>
                                    </select>
                                </div>
                            </div>

                            <div style={groupStyle}>
                                <label style={labelStyle}>Alterar Imagem de Capa (Thumb)</label>
                                <input type="file" onChange={e => setData('thumb', e.target.files[0])} style={fieldStyle} accept="image/*" />
                                {errors.thumb && <p style={errorStyle}>{errors.thumb}</p>}
                            </div>

                            <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: 16 }}>
                                <button type="button" onClick={handleDelete} style={{ padding: '10px 24px', borderRadius: 8, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d', cursor: 'pointer', fontSize: 14 }}>Excluir</button>
                                <button type="submit" disabled={processing} className="btn-primary" style={{ opacity: processing ? 0.6 : 1 }}>
                                    {processing ? 'Salvando...' : 'Salvar Alterações'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    {/* Imagem de Capa Atual */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155', textAlign: 'center' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Imagem de Capa</h3>
                        {project.path ? (
                            <img src={`/storage/images/projects/${project.path}`} alt={project.title} style={{ width: '100%', borderRadius: 8, border: '1px solid #334155', maxHeight: 180, objectFit: 'cover' }} />
                        ) : (
                            <div style={{ height: 150, background: '#0f172a', borderRadius: 8, border: '1px dashed #334155', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#64748b' }}>Sem Imagem de Capa</div>
                        )}
                    </div>

                    {/* Upload de Arquivos */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Arquivos / Documentos</h3>
                        <form onSubmit={handleUploadFiles} style={{ marginBottom: 20 }}>
                            <div style={{ maxHeight: 180, overflowY: 'auto', marginBottom: 12 }}>
                                <div style={{ display: 'flex', gap: 12, marginBottom: 8 }}>
                                    <input type="file" className="project-file-input" required style={{ ...fieldStyle, flex: 1 }} />
                                    <input type="text" placeholder="Nome do arquivo..." value={fileTitles[0] || ''} onChange={e => {
                                        const t = [...fileTitles];
                                        t[0] = e.target.value;
                                        setFileTitles(t);
                                    }} style={{ ...fieldStyle, width: 120 }} />
                                </div>
                                {files.map((_, i) => (
                                    <div key={i} style={{ display: 'flex', gap: 12, marginBottom: 8, alignItems: 'center' }}>
                                        <input type="file" className="project-file-input" required style={{ ...fieldStyle, flex: 1 }} />
                                        <input type="text" placeholder="Nome do arquivo..." value={fileTitles[i + 1] || ''} onChange={e => {
                                            const t = [...fileTitles];
                                            t[i + 1] = e.target.value;
                                            setFileTitles(t);
                                        }} style={{ ...fieldStyle, width: 120 }} />
                                        <button type="button" onClick={() => handleRemoveFileInput(i)} style={{ background: 'none', border: 'none', color: '#f87171', cursor: 'pointer', fontSize: 18 }}>×</button>
                                    </div>
                                ))}
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                                <button type="button" onClick={handleAddFileInput} style={{ background: '#334155', color: '#94a3b8', border: 'none', borderRadius: 6, padding: '6px 12px', cursor: 'pointer', fontSize: 12 }}>+ Novo Arquivo</button>
                                <button type="submit" className="btn-primary">Fazer Upload</button>
                            </div>
                        </form>

                        <div style={{ maxHeight: 180, overflowY: 'auto' }}>
                            {project_files?.length === 0 ? (
                                <p style={{ color: '#64748b', fontSize: 13, textAlign: 'center', margin: '20px 0' }}>Nenhum arquivo anexado.</p>
                            ) : (
                                project_files?.map(f => (
                                    <div key={f.id} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '8px 12px', background: '#0f172a', borderRadius: 8, marginBottom: 8, border: '1px solid #334155' }}>
                                        <div style={{ color: '#f1f5f9', fontSize: 13, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap', maxWidth: 160 }}>{f.title}</div>
                                        <a href={route('arquivos.show', f.id)} target="_blank" rel="noopener noreferrer" style={{ padding: '4px 10px', borderRadius: 6, background: '#334155', color: '#38bdf8', fontSize: 12, textDecoration: 'none' }}>Ver</a>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
