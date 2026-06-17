import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function DirectHireShow({ direct_hire, modalities, situations, possible_winners }) {
    // 1. Form de Edição da Contratação Direta
    const { data: dhData, setData: setDhData, put: putDh, processing: dhProcessing, errors: dhErrors } = useForm({
        title: direct_hire.title || '',
        status: direct_hire.status || 'DRAFT',
        modality_id: direct_hire.modality_id || '',
        situation_id: direct_hire.situation_id || '',
        bidding: direct_hire.bidding || '',
        value_min: direct_hire.value_min || '',
        value_max: direct_hire.value_max || '',
        local: direct_hire.local || '',
        content: direct_hire.content || '',
        process: direct_hire.process || '',
        published_at: direct_hire.published_at ? direct_hire.published_at.substring(0, 10) : '',
        realized_at: direct_hire.realized_at ? direct_hire.realized_at.substring(0, 10) : '',
    });

    // 2. Form de Cadastro de Vencedor
    const [selectedWinner, setSelectedWinner] = useState('');
    const handleAddWinner = (e) => {
        e.preventDefault();
        if (!selectedWinner) return;
        Inertia.post(route('contratacao_direta_vencedores.store'), {
            direct_hire_id: direct_hire.id,
            people_id: selectedWinner
        }, {
            onSuccess: () => setSelectedWinner('')
        });
    };

    // 3. Form de Cadastro de Item
    const { data: itemData, setData: setItemData, post: postItem, processing: itemProcessing, errors: itemErrors, reset: resetItem } = useForm({
        direct_hire_id: direct_hire.id,
        name: '',
        quantity: '',
        value: '',
        people_id: '',
    });

    const handleAddItem = (e) => {
        e.preventDefault();
        postItem(route('contratacao_direta_itens.store'), {
            onSuccess: () => resetItem('name', 'quantity', 'value', 'people_id')
        });
    };

    // 4. Form de Upload de Arquivos
    const [files, setFiles] = useState([]);
    const [fileTitles, setFileTitles] = useState(['']);

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
        formData.append('type', 'direct_hire');
        formData.append('id', direct_hire.id);

        let hasFiles = false;
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach((input, index) => {
            if (input.files[0]) {
                formData.append(`files[document][${index}]`, input.files[0]);
                formData.append(`files[title][${index}]`, fileTitles[index] || input.files[0].name);
                hasFiles = true;
            }
        });

        if (!hasFiles) {
            alert('Por favor, selecione pelo menos um arquivo.');
            return;
        }

        Inertia.post(route('arquivos.store'), formData, {
            onSuccess: () => {
                setFiles([]);
                setFileTitles(['']);
            }
        });
    };

    const handleUpdateDh = (e) => {
        e.preventDefault();
        putDh(route('contratacoes_diretas.update', direct_hire.id));
    };

    const handleDeleteDh = () => {
        if (confirm('Tem certeza que deseja excluir esta contratação direta?')) {
            Inertia.delete(route('contratacoes_diretas.destroy', direct_hire.id));
        }
    };

    const handleDeleteItem = (itemId) => {
        if (confirm('Tem certeza que deseja remover este item?')) {
            Inertia.delete(route('contratacao_direta_itens.destroy', itemId));
        }
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
        <AdminLayout title="Detalhes da Contratação Direta">
            <Head title={`Editar: ${direct_hire.title}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Detalhes da Contratação Direta</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>Gerencie as informações, vencedores, arquivos e itens</p>
                </div>
                <Link href={route('contratacoes_diretas.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24, marginBottom: 24 }}>
                {/* Form Principal de Edição */}
                <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Editar Dados Gerais</h3>
                    <form onSubmit={handleUpdateDh}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome / Título *</label>
                            <input type="text" value={dhData.title} onChange={e => setDhData('title', e.target.value)} style={fieldStyle} required />
                            {dhErrors.title && <p style={errorStyle}>{dhErrors.title}</p>}
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Número da Contratação</label>
                                <input type="text" value={dhData.bidding} onChange={e => setDhData('bidding', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Processo</label>
                                <input type="text" value={dhData.process} onChange={e => setDhData('process', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor Mínimo (R$)</label>
                                <input type="number" step="0.01" value={dhData.value_min} onChange={e => setDhData('value_min', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Valor Estimativa (R$)</label>
                                <input type="number" step="0.01" value={dhData.value_max} onChange={e => setDhData('value_max', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Local</label>
                            <input type="text" value={dhData.local} onChange={e => setDhData('local', e.target.value)} style={fieldStyle} />
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Objeto</label>
                            <textarea value={dhData.content} onChange={e => setDhData('content', e.target.value)} rows={3} style={{ ...fieldStyle, resize: 'vertical' }} />
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Modalidade</label>
                                <select value={dhData.modality_id} onChange={e => setDhData('modality_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {modalities.map(m => <option key={m.id} value={m.id}>{m.title}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Situação</label>
                                <select value={dhData.situation_id} onChange={e => setDhData('situation_id', e.target.value)} style={fieldStyle}>
                                    <option value="">Selecione...</option>
                                    {situations.map(s => <option key={s.id} value={s.id}>{s.title}</option>)}
                                </select>
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Status</label>
                                <select value={dhData.status} onChange={e => setDhData('status', e.target.value)} style={fieldStyle}>
                                    <option value="DRAFT">Desenvolvendo</option>
                                    <option value="PENDING">Pendente</option>
                                    <option value="PUBLISHED">Publicada</option>
                                </select>
                            </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 12 }}>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Publicação do Edital</label>
                                <input type="date" value={dhData.published_at} onChange={e => setDhData('published_at', e.target.value)} style={fieldStyle} />
                            </div>
                            <div style={groupStyle}>
                                <label style={labelStyle}>Data da Licitação</label>
                                <input type="date" value={dhData.realized_at} onChange={e => setDhData('realized_at', e.target.value)} style={fieldStyle} />
                            </div>
                        </div>

                        <div style={{ display: 'flex', gap: 12, justifyContent: 'flex-end', marginTop: 16 }}>
                            <button type="button" onClick={handleDeleteDh} style={{ padding: '10px 24px', borderRadius: 8, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d', cursor: 'pointer', fontSize: 14 }}>Excluir</button>
                            <button type="submit" disabled={dhProcessing} className="btn-primary" style={{ opacity: dhProcessing ? 0.6 : 1 }}>
                                {dhProcessing ? 'Salvando...' : 'Salvar Alterações'}
                            </button>
                        </div>
                    </form>
                </div>

                {/* Vencedores & Arquivos */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    {/* Seção Vencedores */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Vencedores</h3>
                        <form onSubmit={handleAddWinner} style={{ display: 'flex', gap: 12, marginBottom: 20 }}>
                            <select value={selectedWinner} onChange={e => setSelectedWinner(e.target.value)} style={fieldStyle}>
                                <option value="">Selecione um Vencedor...</option>
                                {possible_winners.map(pw => <option key={pw.id} value={pw.id}>{pw.full_name}</option>)}
                            </select>
                            <button type="submit" className="btn-primary" style={{ whiteSpace: 'nowrap' }}>+ Adicionar</button>
                        </form>

                        <div style={{ maxHeight: 200, overflowY: 'auto' }}>
                            {direct_hire.winners?.length === 0 ? (
                                <p style={{ color: '#64748b', fontSize: 13, textAlign: 'center', margin: '20px 0' }}>Nenhum vencedor cadastrado.</p>
                            ) : (
                                direct_hire.winners?.map(w => (
                                    <div key={w.id} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '10px 12px', background: '#0f172a', borderRadius: 8, marginBottom: 8, border: '1px solid #334155' }}>
                                        <div>
                                            <div style={{ color: '#f1f5f9', fontSize: 14, fontWeight: 500 }}>{w.person?.full_name}</div>
                                            <div style={{ color: '#64748b', fontSize: 11 }}>{w.person?.email || 'Sem e-mail'}</div>
                                        </div>
                                        <Link href={route('contratacao_direta_vencedores.show', w.people_id)} style={{ padding: '4px 10px', borderRadius: 6, background: '#334155', color: '#38bdf8', fontSize: 12, textDecoration: 'none' }}>Editar</Link>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>

                    {/* Seção Arquivos */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Arquivos Anexados</h3>
                        <form onSubmit={handleUploadFiles} style={{ marginBottom: 20 }}>
                            <div style={{ maxHeight: 150, overflowY: 'auto', marginBottom: 12 }}>
                                <div style={{ display: 'flex', gap: 12, marginBottom: 8 }}>
                                    <input type="file" required style={{ ...fieldStyle, flex: 1 }} />
                                    <input type="text" placeholder="Nome do arquivo..." value={fileTitles[0] || ''} onChange={e => {
                                        const t = [...fileTitles];
                                        t[0] = e.target.value;
                                        setFileTitles(t);
                                    }} style={{ ...fieldStyle, width: 150 }} />
                                </div>
                                {files.map((_, i) => (
                                    <div key={i} style={{ display: 'flex', gap: 12, marginBottom: 8, alignItems: 'center' }}>
                                        <input type="file" required style={{ ...fieldStyle, flex: 1 }} />
                                        <input type="text" placeholder="Nome do arquivo..." value={fileTitles[i + 1] || ''} onChange={e => {
                                            const t = [...fileTitles];
                                            t[i + 1] = e.target.value;
                                            setFileTitles(t);
                                        }} style={{ ...fieldStyle, width: 150 }} />
                                        <button type="button" onClick={() => handleRemoveFileInput(i)} style={{ background: 'none', border: 'none', color: '#f87171', cursor: 'pointer', fontSize: 18 }}>×</button>
                                    </div>
                                ))}
                            </div>
                            <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                                <button type="button" onClick={handleAddFileInput} style={{ background: '#334155', color: '#94a3b8', border: 'none', borderRadius: 6, padding: '6px 12px', cursor: 'pointer', fontSize: 12 }}>+ Outro Arquivo</button>
                                <button type="submit" className="btn-primary">Fazer Upload</button>
                            </div>
                        </form>

                        <div style={{ maxHeight: 150, overflowY: 'auto' }}>
                            {direct_hire.files?.length === 0 ? (
                                <p style={{ color: '#64748b', fontSize: 13, textAlign: 'center', margin: '20px 0' }}>Nenhum arquivo anexado.</p>
                            ) : (
                                direct_hire.files?.map(f => (
                                    <div key={f.id} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '8px 12px', background: '#0f172a', borderRadius: 8, marginBottom: 8, border: '1px solid #334155' }}>
                                        <div style={{ color: '#f1f5f9', fontSize: 13, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap', maxWidth: 220 }}>{f.title}</div>
                                        <a href={route('arquivos.show', f.id)} target="_blank" rel="noopener noreferrer" style={{ padding: '4px 10px', borderRadius: 6, background: '#334155', color: '#38bdf8', fontSize: 12, textDecoration: 'none' }}>Visualizar</a>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Seção Itens */}
            <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20 }}>Itens Cadastrados</h3>

                {/* Form de Item */}
                <form onSubmit={handleAddItem} style={{ display: 'grid', gridTemplateColumns: '2fr 1fr 1fr 2fr auto', gap: 12, marginBottom: 24, alignItems: 'end' }}>
                    <div>
                        <label style={labelStyle}>Descrição do Item *</label>
                        <input type="text" value={itemData.name} onChange={e => setItemData('name', e.target.value)} style={fieldStyle} required />
                    </div>
                    <div>
                        <label style={labelStyle}>Quantidade *</label>
                        <input type="number" value={itemData.quantity} onChange={e => setItemData('quantity', e.target.value)} style={fieldStyle} required />
                    </div>
                    <div>
                        <label style={labelStyle}>Custo Unitário (R$) *</label>
                        <input type="number" step="0.01" value={itemData.value} onChange={e => setItemData('value', e.target.value)} style={fieldStyle} required />
                    </div>
                    <div>
                        <label style={labelStyle}>Vencedor</label>
                        <select value={itemData.people_id} onChange={e => setItemData('people_id', e.target.value)} style={fieldStyle}>
                            <option value="">Selecione...</option>
                            {direct_hire.winners?.map(w => <option key={w.people_id} value={w.people_id}>{w.person?.full_name}</option>)}
                        </select>
                    </div>
                    <button type="submit" disabled={itemProcessing} className="btn-primary" style={{ height: 40, opacity: itemProcessing ? 0.6 : 1 }}>
                        {itemProcessing ? '...' : '+ Adicionar Item'}
                    </button>
                </form>

                {/* Tabela de Itens */}
                <div style={{ background: '#0f172a', borderRadius: 8, overflow: 'hidden', border: '1px solid #334155' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                        <thead>
                            <tr style={{ borderBottom: '1px solid #334155' }}>
                                {['Item', 'Qtd', 'Custo (R$)', 'Total (R$)', 'Vencedor', 'Ações'].map(h => (
                                    <th key={h} style={{ padding: '10px 12px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase' }}>{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {direct_hire.items?.length === 0 ? (
                                <tr><td colSpan={6} style={{ padding: 24, textAlign: 'center', color: '#64748b' }}>Nenhum item cadastrado para esta contratação</td></tr>
                            ) : (
                                direct_hire.items?.map(item => (
                                    <tr key={item.id} style={{ borderBottom: '1px solid #1e293b' }}>
                                        <td style={{ padding: '10px 12px', color: '#f1f5f9', fontSize: 13 }}>{item.name}</td>
                                        <td style={{ padding: '10px 12px', color: '#94a3b8', fontSize: 13 }}>{item.quantity}</td>
                                        <td style={{ padding: '10px 12px', color: '#94a3b8', fontSize: 13 }}>
                                            {item.value ? Number(item.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '0,00'}
                                        </td>
                                        <td style={{ padding: '10px 12px', color: '#10b981', fontWeight: 600, fontSize: 13 }}>
                                            {(item.value && item.quantity) ? (Number(item.value) * Number(item.quantity)).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : '0,00'}
                                        </td>
                                        <td style={{ padding: '10px 12px', color: '#94a3b8', fontSize: 13 }}>
                                            {possible_winners.find(pw => pw.id === item.people_id)?.full_name || '—'}
                                        </td>
                                        <td style={{ padding: '10px 12px' }}>
                                            <div style={{ display: 'flex', gap: 8 }}>
                                                <Link href={route('contratacao_direta_itens.show', item.id)} style={{ padding: '3px 8px', borderRadius: 4, background: '#334155', color: '#38bdf8', fontSize: 11, textDecoration: 'none' }}>Editar</Link>
                                                <button onClick={() => handleDeleteItem(item.id)} style={{ padding: '3px 8px', borderRadius: 4, background: '#7f1d1d20', color: '#f87171', border: 'none', cursor: 'pointer', fontSize: 11 }}>Remover</button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
