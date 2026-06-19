import React from 'react';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function Show({ management_report, management_report_types = [], unit }) {
    // Formulário de Edição do Relatório
    const { 
        data: reportData, 
        setData: setReportData, 
        put: putReport, 
        processing: reportProcessing, 
        errors: reportErrors 
    } = useForm({
        management_report_type_id: management_report.management_report_type_id || '',
        status: management_report.status || 'DRAFT',
        initial_date: management_report.initial_date || '',
        final_date: management_report.final_date || '',
    });

    // Formulário de Upload de Arquivo
    const { 
        data: fileData, 
        setData: setFileData, 
        post: postFile, 
        processing: fileProcessing, 
        errors: fileErrors,
        reset: resetFileForm
    } = useForm({
        type: 'management_report',
        id: management_report.id,
        files: {
            document: [null],
            title: ['']
        }
    });

    const handleReportSubmit = (e) => {
        e.preventDefault();
        putReport(route('relatorio_de_gestao.update', management_report.id));
    };

    const handleFileSubmit = (e) => {
        e.preventDefault();
        
        if (!fileData.files.document[0]) {
            alert('Por favor, selecione um arquivo.');
            return;
        }
        if (!fileData.files.title[0]) {
            alert('Por favor, defina um nome para o arquivo.');
            return;
        }

        if (confirm('Tem certeza que deseja salvar o arquivo?')) {
            postFile(route('arquivos.store'), {
                onSuccess: () => {
                    resetFileForm('files');
                }
            });
        }
    };

    const formatDate = (dateStr) => {
        if (!dateStr) return '—';
        try {
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return dateStr;
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        } catch (e) {
            return dateStr;
        }
    };

    const fieldStyle = {
        width: '100%', 
        padding: '10px 14px', 
        borderRadius: 8,
        border: '1px solid #334155', 
        background: '#0f172a',
        color: '#f1f5f9', 
        fontSize: 14, 
        boxSizing: 'border-box',
    };
    const labelStyle = { display: 'block', color: '#94a3b8', fontSize: 13, marginBottom: 6, fontWeight: 500 };
    const errorStyle = { color: '#f87171', fontSize: 12, marginTop: 4 };
    const groupStyle = { marginBottom: 20 };

    return (
        <AdminLayout title={`Relatório de Gestão #${management_report.id}`}>
            <Head title={`Editar Relatório #${management_report.id}`} />

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>
                        Editar Relatório de Gestão
                    </h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0' }}>
                        Atualize as informações do relatório ou anexe arquivos
                    </p>
                </div>
                <Link href={route('relatorio_de_gestao.index')} style={{ padding: '8px 18px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>← Voltar</Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1.2fr 1fr', gap: 24, alignItems: 'start' }}>
                
                {/* Formulário de Edição */}
                <form onSubmit={handleReportSubmit} style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                    <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20, fontWeight: 600 }}>Informações Gerais</h3>

                    <div style={groupStyle}>
                        <label style={labelStyle}>Tipo de Relatório *</label>
                        <select 
                            value={reportData.management_report_type_id} 
                            onChange={e => setReportData('management_report_type_id', e.target.value)} 
                            style={fieldStyle} 
                            required
                        >
                            <option value="">Selecione...</option>
                            {management_report_types.map(type => (
                                <option key={type.id} value={type.id}>{type.type}</option>
                            ))}
                        </select>
                        {reportErrors.management_report_type_id && <p style={errorStyle}>{reportErrors.management_report_type_id}</p>}
                    </div>

                    <div style={groupStyle}>
                        <label style={labelStyle}>Status *</label>
                        <select 
                            value={reportData.status} 
                            onChange={e => setReportData('status', e.target.value)} 
                            style={fieldStyle} 
                            required
                        >
                            <option value="DRAFT">Desenvolvendo</option>
                            <option value="PENDING">Pendente</option>
                            <option value="PUBLISHED">Publicada</option>
                        </select>
                        {reportErrors.status && <p style={errorStyle}>{reportErrors.status}</p>}
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                        <div style={groupStyle}>
                            <label style={labelStyle}>Data Inicial *</label>
                            <input 
                                type="date" 
                                value={reportData.initial_date} 
                                onChange={e => setReportData('initial_date', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {reportErrors.initial_date && <p style={errorStyle}>{reportErrors.initial_date}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Data Final *</label>
                            <input 
                                type="date" 
                                value={reportData.final_date} 
                                onChange={e => setReportData('final_date', e.target.value)} 
                                style={fieldStyle} 
                                required 
                            />
                            {reportErrors.final_date && <p style={errorStyle}>{reportErrors.final_date}</p>}
                        </div>
                    </div>

                    <div style={{ marginTop: 12, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                        <Link href={route('relatorio_de_gestao.index')} style={{ padding: '10px 24px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14, fontWeight: 500 }}>Cancelar</Link>
                        <button 
                            type="submit" 
                            disabled={reportProcessing} 
                            className="btn-primary" 
                            style={{ opacity: reportProcessing ? 0.6 : 1 }}
                        >
                            {reportProcessing ? 'Salvando...' : 'Salvar Alterações'}
                        </button>
                    </div>
                </form>

                {/* Seção de Arquivo e Upload */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
                    
                    {/* Formulário de Upload */}
                    <form onSubmit={handleFileSubmit} style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 8, fontWeight: 600 }}>Adicionar Arquivo</h3>
                        <p style={{ color: '#64748b', fontSize: 13, marginTop: 0, marginBottom: 20 }}>
                            Selecione o arquivo para fazer upload e associar a este relatório
                        </p>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Arquivo (Obrigatório)</label>
                            <input 
                                type="file" 
                                onChange={e => {
                                    const newFiles = { ...fileData.files };
                                    newFiles.document[0] = e.target.files[0];
                                    setFileData('files', newFiles);
                                }} 
                                style={fieldStyle} 
                                required
                            />
                            {fileErrors['files.document.0'] && <p style={errorStyle}>{fileErrors['files.document.0']}</p>}
                        </div>

                        <div style={groupStyle}>
                            <label style={labelStyle}>Nome do Arquivo (Obrigatório)</label>
                            <input 
                                type="text" 
                                value={fileData.files.title[0]} 
                                onChange={e => {
                                    const newFiles = { ...fileData.files };
                                    newFiles.title[0] = e.target.value;
                                    setFileData('files', newFiles);
                                }} 
                                placeholder="Ex: Relatório de Gestão Semestral 2026"
                                style={fieldStyle} 
                                required
                            />
                            {fileErrors['files.title.0'] && <p style={errorStyle}>{fileErrors['files.title.0']}</p>}
                        </div>

                        <button 
                            type="submit" 
                            disabled={fileProcessing} 
                            className="btn-primary" 
                            style={{ width: '100%', padding: '12px 14px', fontSize: 15, opacity: fileProcessing ? 0.6 : 1 }}
                        >
                            {fileProcessing ? 'Enviando...' : 'Salvar Arquivo'}
                        </button>
                    </form>

                    {/* Arquivo Cadastrado */}
                    <div style={{ background: '#1e293b', borderRadius: 12, padding: 24, border: '1px solid #334155' }}>
                        <h3 style={{ color: '#f1f5f9', fontSize: 16, marginTop: 0, marginBottom: 20, fontWeight: 600 }}>Arquivo Cadastrado</h3>
                        
                        {management_report.file ? (
                            <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
                                <div>
                                    <p style={{ color: '#f1f5f9', fontSize: 14, fontWeight: 500, margin: '0 0 4px' }}>
                                        {management_report.file.title}
                                    </p>
                                    <p style={{ color: '#64748b', fontSize: 12, margin: 0 }}>
                                        Cadastrado em: {formatDate(management_report.file.created_at)}
                                    </p>
                                </div>
                                <div style={{ display: 'flex', gap: 8 }}>
                                    <a 
                                        href={route('arquivos.show', management_report.file.id)} 
                                        target="_blank" 
                                        rel="noopener noreferrer" 
                                        className="btn-primary" 
                                        style={{ 
                                            padding: '8px 16px', 
                                            fontSize: 13, 
                                            textDecoration: 'none', 
                                            textAlign: 'center',
                                            flex: 1
                                        }}
                                    >
                                        Abrir Arquivo
                                    </a>
                                </div>
                            </div>
                        ) : (
                            <div style={{ padding: '16px', borderRadius: 8, background: '#7f1d1d15', border: '1px solid #7f1d1d50', color: '#f87171', fontSize: 13 }}>
                                Não existem arquivos armazenados para este relatório de gestão.
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
