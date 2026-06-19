import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ legislation_subjects, unit }) {
    const { flash } = usePage().props;
    const [search, setSearch] = useState('');
    const [showForm, setShowForm] = useState(false);

    // Form state
    const [formData, setFormData] = useState({
        subject: '',
    });
    const [errors, setErrors] = useState({});

    const filtered = legislation_subjects.filter(s =>
        s.subject?.toLowerCase().includes(search.toLowerCase())
    );

    const resetForm = () => {
        setFormData({ subject: '' });
        setErrors({});
        setShowForm(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors({});

        Inertia.post('/legislacao_assuntos', formData, {
            onSuccess: () => resetForm(),
            onError: (err) => setErrors(err),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Tem certeza que deseja excluir este Assunto?')) {
            Inertia.delete(`/legislacao_assuntos/${id}`);
        }
    };

    return (
        <>
            <Head title="Assuntos de Legislação" />

            <div style={{ padding: '32px', maxWidth: '1200px', margin: '0 auto' }}>
                {/* Flash Messages */}
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
                        📚 Assuntos de Legislação
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
                        {showForm ? '✕ Cancelar' : '+ Novo Assunto'}
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
                            📤 Cadastrar Novo Assunto
                        </h2>

                        <div style={{ marginBottom: '16px' }}>
                            <label style={labelStyle}>Nome do Assunto *</label>
                            <input
                                type="text"
                                value={formData.subject}
                                onChange={e => setFormData({ ...formData, subject: e.target.value })}
                                required
                                style={{
                                    ...inputStyle,
                                    borderColor: errors.subject ? '#ef4444' : '#cbd5e1'
                                }}
                            />
                            {errors.subject && (
                                <span style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '4px', display: 'block' }}>
                                    {errors.subject}
                                </span>
                            )}
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
                            Cadastrar
                        </button>
                    </form>
                )}

                {/* Search */}
                <div style={{ marginBottom: '20px' }}>
                    <input
                        type="text"
                        placeholder="🔍 Buscar assunto por nome..."
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
                        Nenhum assunto de legislação encontrado.
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
                                    <th style={thStyle}>Assunto</th>
                                    <th style={thStyle}>Cadastrado em</th>
                                    <th style={{ ...thStyle, textAlign: 'right' }}>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((sub) => (
                                    <tr key={sub.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                                        <td style={tdStyle}>
                                            <div style={{ fontWeight: 600, color: '#1e293b' }}>{sub.subject}</div>
                                        </td>
                                        <td style={tdStyle}>
                                            <span style={{ fontSize: '0.85rem', color: '#64748b' }}>
                                                {sub.created_at ? new Date(sub.created_at).toLocaleDateString('pt-BR') : '—'}
                                            </span>
                                        </td>
                                        <td style={{ ...tdStyle, textAlign: 'right' }}>
                                            <div style={{ display: 'inline-flex', gap: '8px' }}>
                                                <a
                                                    href={`/legislacao_assuntos/${sub.id}`}
                                                    style={btnSmall('#2563eb')}
                                                >
                                                    👁 Ver / Editar
                                                </a>
                                                <button
                                                    onClick={() => handleDelete(sub.id)}
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
