import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ faqs, departaments, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState(null);

    // Form state
    const [formData, setFormData] = useState({
        question: '',
        answer: '',
        departament_id: '',
        status: 'DRAFT',
    });

    const filtered = faqs.filter(f =>
        f.question?.toLowerCase().includes(search.toLowerCase()) ||
        f.answer?.toLowerCase().includes(search.toLowerCase()) ||
        f.departament?.sigla?.toLowerCase().includes(search.toLowerCase()) ||
        f.departament?.departament?.toLowerCase().includes(search.toLowerCase())
    );

    const resetForm = () => {
        setFormData({
            question: '',
            answer: '',
            departament_id: departaments[0]?.id || '',
            status: 'DRAFT',
        });
        setEditingId(null);
        setShowForm(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        
        const payload = {
            question: formData.question,
            answer: formData.answer,
            departament_id: formData.departament_id || (departaments[0]?.id || ''),
            status: formData.status,
        };

        if (editingId) {
            Inertia.put(`/faqs/${editingId}`, payload, {
                onSuccess: () => resetForm(),
            });
        } else {
            Inertia.post('/faqs', payload, {
                onSuccess: () => resetForm(),
            });
        }
    };

    const handleEdit = (faq) => {
        setFormData({
            question: faq.question || '',
            answer: faq.answer || '',
            departament_id: faq.departament_id || '',
            status: faq.status || 'DRAFT',
        });
        setEditingId(faq.id);
        setShowForm(true);
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir esta FAQ?')) {
            Inertia.delete(`/faqs/${id}`);
        }
    };

    const getStatusLabel = (status) => {
        switch (status) {
            case 'DRAFT': return 'Em Edição';
            case 'PENDING': return 'Em Espera';
            case 'PUBLISHED': return 'Publicado';
            default: return status;
        }
    };

    const getStatusBadge = (status) => {
        const styles = {
            PUBLISHED: { bg: '#dcfce7', color: '#166534' },
            PENDING: { bg: '#dbeafe', color: '#1e40af' },
            DRAFT: { bg: '#fef9c3', color: '#854d0e' },
        };
        const s = styles[status] || styles.DRAFT;
        return (
            <span style={{
                padding: '3px 10px',
                borderRadius: '12px',
                fontSize: '0.72rem',
                fontWeight: 700,
                backgroundColor: s.bg,
                color: s.color,
            }}>
                {getStatusLabel(status)}
            </span>
        );
    };

    return (
        <>
            <Head title="FAQs" />

            <div style={{ padding: '32px', maxWidth: '1200px', margin: '0 auto' }}>
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

                {/* Header */}
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
                    <h1 style={{ fontSize: '1.75rem', fontWeight: 700, color: '#1e293b', margin: 0 }}>
                        🙋‍♂️ Perguntas Frequentes (FAQs)
                    </h1>
                    <button
                        onClick={() => {
                            if (!showForm) {
                                resetForm();
                                setShowForm(true);
                            } else {
                                resetForm();
                            }
                        }}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: showForm ? '#64748b' : '#2563eb',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                            fontSize: '0.9rem',
                        }}
                    >
                        {showForm ? '✕ Cancelar' : '+ Nova FAQ'}
                    </button>
                </div>

                {/* Form */}
                {showForm && (
                    <form onSubmit={handleSubmit} style={{
                        backgroundColor: '#f8fafc',
                        padding: '24px',
                        borderRadius: '12px',
                        marginBottom: '24px',
                        border: '1px solid #e2e8f0',
                    }}>
                        <h2 style={{ fontSize: '1.1rem', fontWeight: 600, marginBottom: '16px', color: '#334155' }}>
                            {editingId ? '✏️ Editar FAQ' : '📤 Cadastrar Nova FAQ'}
                        </h2>

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

                        <div style={{ marginBottom: '20px' }}>
                            <label style={labelStyle}>Resposta *</label>
                            <textarea
                                value={formData.answer}
                                onChange={e => setFormData({ ...formData, answer: e.target.value })}
                                required
                                rows="3"
                                style={{ ...inputStyle, fontFamily: 'inherit', resize: 'vertical' }}
                            />
                        </div>

                        <button type="submit" style={{
                            padding: '10px 28px',
                            backgroundColor: '#2563eb',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '8px',
                            cursor: 'pointer',
                            fontWeight: 600,
                        }}>
                            {editingId ? 'Salvar Alterações' : 'Cadastrar'}
                        </button>
                    </form>
                )}

                {/* Search */}
                <div style={{ marginBottom: '20px' }}>
                    <input
                        type="text"
                        placeholder="🔍 Buscar FAQ por pergunta, resposta ou departamento..."
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        style={{
                            ...inputStyle,
                            maxWidth: '360px',
                        }}
                    />
                </div>

                {/* List / Table */}
                {filtered.length === 0 ? (
                    <p style={{ color: '#94a3b8', textAlign: 'center', padding: '48px 0' }}>
                        Nenhuma FAQ cadastrada.
                    </p>
                ) : (
                    <div style={{
                        backgroundColor: '#fff',
                        borderRadius: '12px',
                        border: '1px solid #e2e8f0',
                        overflow: 'hidden',
                        boxShadow: '0 1px 3px rgba(0,0,0,0.02)',
                    }}>
                        <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                            <thead>
                                <tr style={{ backgroundColor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                                    <th style={thStyle}>Pergunta</th>
                                    <th style={thStyle}>Resposta</th>
                                    <th style={thStyle}>Departamento</th>
                                    <th style={thStyle}>Status</th>
                                    <th style={{ ...thStyle, textAlign: 'right' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((faq) => (
                                    <tr key={faq.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                                        <td style={tdStyle}>
                                            <div style={{ fontWeight: 600, color: '#1e293b' }}>{faq.question}</div>
                                        </td>
                                        <td style={{ ...tdStyle, color: '#475569', maxWidth: '320px', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>
                                            {faq.answer}
                                        </td>
                                        <td style={tdStyle}>
                                            <span style={{ fontSize: '0.85rem', fontWeight: 600, color: '#64748b' }}>
                                                {faq.departament?.sigla || '—'}
                                            </span>
                                        </td>
                                        <td style={tdStyle}>
                                            {getStatusBadge(faq.status)}
                                        </td>
                                        <td style={{ ...tdStyle, textAlign: 'right' }}>
                                            <div style={{ display: 'inline-flex', gap: '8px' }}>
                                                <a
                                                    href={`/faqs/${faq.id}`}
                                                    style={btnSmall('#2563eb')}
                                                >
                                                    👁 Ver
                                                </a>
                                                <button
                                                    onClick={() => handleEdit(faq)}
                                                    style={btnSmall('#f59e0b')}
                                                >
                                                    ✏️ Editar
                                                </button>
                                                <button
                                                    onClick={() => handleDelete(faq.id)}
                                                    style={btnSmall('#ef4444')}
                                                >
                                                    🗑 Excluir
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
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

const thStyle = {
    padding: '12px 16px',
    fontSize: '0.8rem',
    fontWeight: 700,
    color: '#475569',
    textTransform: 'uppercase',
    letterSpacing: '0.05em',
};

const tdStyle = {
    padding: '16px',
    fontSize: '0.9rem',
    verticalAlign: 'middle',
};

const btnSmall = (bg) => ({
    padding: '5px 12px',
    backgroundColor: bg,
    color: '#fff',
    border: 'none',
    borderRadius: '6px',
    cursor: 'pointer',
    fontSize: '0.78rem',
    fontWeight: 600,
    textDecoration: 'none',
    display: 'inline-flex',
    alignItems: 'center',
    justifyContent: 'center',
});
