import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Show({ faq, departaments, unit }) {
    const { flash } = usePage().props;

    const [formData, setFormData] = useState({
        question: faq.question || '',
        answer: faq.answer || '',
        departament_id: faq.departament_id || '',
        status: faq.status || 'DRAFT',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        
        const payload = {
            question: formData.question,
            answer: formData.answer,
            departament_id: formData.departament_id,
            status: formData.status,
        };

        Inertia.put(`/faqs/${faq.id}`, payload);
    };

    const handleDelete = () => {
        if (confirm('Tem certeza que deseja excluir esta FAQ?')) {
            Inertia.delete(`/faqs/${faq.id}`);
        }
    };

    return (
        <>
            <Head title={`FAQ - ${faq.question?.substring(0, 30)}...`} />

            <div style={{ padding: '32px', maxWidth: '960px', margin: '0 auto' }}>
                {/* Flash */}
                {flash && flash.message && (
                    <div style={{
                        padding: '12px 20px',
                        marginBottom: '20px',
                        borderRadius: '8px',
                        backgroundColor: flash.type === 'success' ? '#dcfce7' : '#fee2e2',
                        color: flash.type === 'success' ? '#166534' : '#991b1b',
                        border: `1px solid ${flash.type === 'success' ? '#bbf7d0' : '#fecaca'}`,
                    }}>
                        {flash.message}
                    </div>
                )}

                {/* Voltar */}
                <a
                    href="/faqs"
                    style={{
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '6px',
                        color: '#2563eb',
                        textDecoration: 'none',
                        fontWeight: 600,
                        marginBottom: '24px',
                        fontSize: '0.9rem',
                    }}
                >
                    ← Voltar para as FAQs
                </a>

                <h1 style={{ fontSize: '1.5rem', fontWeight: 700, color: '#1e293b', marginBottom: '24px' }}>
                    🙋‍♂️ Visualizar/Editar FAQ
                </h1>

                {/* Info Card */}
                <div style={{
                    backgroundColor: '#f8fafc',
                    padding: '24px',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    marginBottom: '32px',
                }}>
                    <div style={{ marginBottom: '16px' }}>
                        <span style={{ fontSize: '0.8rem', color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase' }}>Pergunta Atual</span>
                        <p style={{ fontWeight: 600, color: '#1e293b', fontSize: '1.1rem', margin: '4px 0 0 0' }}>{faq.question}</p>
                    </div>
                    <div style={{ marginBottom: '16px' }}>
                        <span style={{ fontSize: '0.8rem', color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase' }}>Resposta Atual</span>
                        <p style={{ color: '#475569', fontSize: '0.95rem', margin: '4px 0 0 0', lineHeight: 1.5 }}>{faq.answer}</p>
                    </div>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '16px', borderTop: '1px solid #e2e8f0', paddingTop: '16px' }}>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Departamento</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>
                                {faq.departament?.sigla || '—'} - {faq.departament?.departament || '—'}
                            </p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>Status</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>{faq.status}</p>
                        </div>
                        <div>
                            <span style={{ fontSize: '0.8rem', color: '#94a3b8' }}>ID Registro</span>
                            <p style={{ fontWeight: 600, color: '#1e293b', margin: '4px 0 0 0' }}>#{faq.id}</p>
                        </div>
                    </div>
                </div>

                {/* Formulário de edição */}
                <div style={{
                    backgroundColor: '#fff',
                    borderRadius: '12px',
                    border: '1px solid #e2e8f0',
                    padding: '24px',
                }}>
                    <h2 style={{ fontSize: '1.1rem', fontWeight: 600, color: '#334155', marginBottom: '20px' }}>
                        ✏️ Editar Informações da FAQ
                    </h2>
                    <form onSubmit={handleSubmit}>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '16px' }}>
                            <div>
                                <label style={labelStyle}>Departamento *</label>
                                <select
                                    value={formData.departament_id}
                                    onChange={e => setFormData({ ...formData, departament_id: e.target.value })}
                                    required
                                    style={inputStyle}
                                >
                                    <option value="">Selecione um Departamento</option>
                                    {departaments.map(dept => (
                                        <option key={dept.id} value={dept.id}>
                                            {dept.sigla} - {dept.departament}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div>
                                <label style={labelStyle}>Status *</label>
                                <select
                                    value={formData.status}
                                    onChange={e => setFormData({ ...formData, status: e.target.value })}
                                    required
                                    style={inputStyle}
                                >
                                    <option value="DRAFT">Em Edição</option>
                                    <option value="PENDING">Em Espera</option>
                                    <option value="PUBLISHED">Publicar</option>
                                </select>
                            </div>
                        </div>

                        <div style={{ marginBottom: '16px' }}>
                            <label style={labelStyle}>Pergunta *</label>
                            <input
                                type="text"
                                value={formData.question}
                                onChange={e => setFormData({ ...formData, question: e.target.value })}
                                required
                                style={inputStyle}
                            />
                        </div>

                        <div style={{ marginBottom: '24px' }}>
                            <label style={labelStyle}>Resposta *</label>
                            <textarea
                                value={formData.answer}
                                onChange={e => setFormData({ ...formData, answer: e.target.value })}
                                required
                                rows="4"
                                style={{ ...inputStyle, fontFamily: 'inherit', resize: 'vertical' }}
                            />
                        </div>

                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                            <button type="submit" style={{
                                padding: '10px 28px',
                                backgroundColor: '#2563eb',
                                color: '#fff',
                                border: 'none',
                                borderRadius: '8px',
                                cursor: 'pointer',
                                fontWeight: 600,
                            }}>
                                Salvar Alterações
                            </button>

                            <button
                                type="button"
                                onClick={handleDelete}
                                style={{
                                    padding: '10px 20px',
                                    backgroundColor: '#ef4444',
                                    color: '#fff',
                                    border: 'none',
                                    borderRadius: '8px',
                                    cursor: 'pointer',
                                    fontWeight: 600,
                                }}
                            >
                                🗑 Excluir FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

const labelStyle = {
    display: 'block',
    fontSize: '0.85rem',
    fontWeight: 600,
    color: '#475569',
    marginBottom: '4px',
};

const inputStyle = {
    width: '100%',
    padding: '8px 12px',
    borderRadius: '6px',
    border: '1px solid #cbd5e1',
    fontSize: '0.9rem',
    outline: 'none',
    boxSizing: 'border-box',
};
