import React, { useState } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '../../Components/Layout/AdminLayout';

export default function NotificationIndex({ unit = null, readeds = [], not_readeds = [], sendeds = [], users = [], statuses = [], types = [] }) {
    const { auth } = usePage().props;
    const currentUserId = auth?.user?.id ?? '';

    const [activeTab, setActiveTab] = useState('not_readeds'); // not_readeds, readeds, sendeds
    const [search, setSearch] = useState('');

    // Seleciona a lista de notificações com base na aba ativa
    const getActiveList = () => {
        if (activeTab === 'not_readeds') return not_readeds;
        if (activeTab === 'readeds') return readeds;
        return sendeds;
    };

    const currentList = getActiveList();

    const filtered = currentList.filter(n =>
        n.title?.toLowerCase().includes(search.toLowerCase()) ||
        n.content?.toLowerCase().includes(search.toLowerCase())
    );

    // ── Formulário de Cadastro ──
    const createForm = useForm({
        type_id: types[0]?.id ?? '',
        status_id: statuses.find(s => s.status?.toLowerCase().includes('não lida'))?.id ?? (statuses[0]?.id ?? ''),
        sender_id: currentUserId,
        title: '',
        content: '',
        scheduled_at: '',
        users: [], // IDs dos usuários destinatários
    });

    function handleCreate(e) {
        e.preventDefault();
        createForm.post(route('notificacoes.store'), {
            onSuccess: () => createForm.reset('title', 'content', 'scheduled_at', 'users'),
        });
    }

    function handleDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta Notificação?')) {
            Inertia.delete(route('notificacoes.destroy', id));
        }
    }

    function markAsRead(id) {
        Inertia.get(`/notification/readed/${id}`);
    }

    // ── Estilos ──
    const card  = { background: '#1e293b', borderRadius: 12, border: '1px solid #334155', overflow: 'hidden' };
    const label = { display: 'block', color: '#94a3b8', fontSize: 12, fontWeight: 600, marginBottom: 4, textTransform: 'uppercase', letterSpacing: '0.05em' };
    const input = { width: '100%', padding: '8px 12px', borderRadius: 8, border: '1px solid #334155', background: '#0f172a', color: '#f1f5f9', fontSize: 14, outline: 'none', boxSizing: 'border-box' };
    const btnPrimary  = { padding: '9px 20px', borderRadius: 8, background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff', border: 'none', cursor: 'pointer', fontWeight: 600, fontSize: 14 };
    const btnDanger   = { padding: '5px 10px', borderRadius: 6, background: '#7f1d1d20', color: '#f87171', border: '1px solid #7f1d1d40', cursor: 'pointer', fontSize: 12 };
    const btnSuccess  = { padding: '5px 10px', borderRadius: 6, background: '#065f4620', color: '#34d399', border: '1px solid #065f4640', cursor: 'pointer', fontSize: 12 };

    const tabHeader = { display: 'flex', gap: 8, borderBottom: '1px solid #334155', padding: '0 20px' };
    const tabButton = (active) => ({
        padding: '12px 16px',
        border: 'none',
        background: 'transparent',
        color: active ? '#3b82f6' : '#94a3b8',
        borderBottom: active ? '2px solid #3b82f6' : '2px solid transparent',
        cursor: 'pointer',
        fontSize: 14,
        fontWeight: 600,
        outline: 'none',
        transition: 'all 0.2s'
    });

    const helperText = { color: '#64748b', fontSize: 11, marginTop: 4, display: 'block' };

    return (
        <AdminLayout title="Notificações">
            <Head title="Notificações" />

            {/* Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 28 }}>
                <div>
                    <h1 style={{ fontSize: 24, fontWeight: 700, color: '#f1f5f9', margin: 0 }}>Notificações</h1>
                    <p style={{ color: '#64748b', margin: '4px 0 0', fontSize: 14 }}>
                        Configuração · Gestão de alertas e mensagens internas do sistema
                    </p>
                </div>
                <Link
                    href={route('dashboard')}
                    style={{ padding: '8px 16px', borderRadius: 8, background: '#334155', color: '#94a3b8', textDecoration: 'none', fontSize: 14 }}
                >
                    ← Dashboard
                </Link>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '360px 1fr', gap: 24, alignItems: 'start' }}>

                {/* ── Painel Esquerdo: Formulário de Cadastro ── */}
                <div style={{ ...card }}>
                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155' }}>
                        <h2 style={{ margin: 0, fontSize: 15, fontWeight: 600, color: '#f1f5f9' }}>
                            ✉️ Nova Notificação
                        </h2>
                    </div>
                    <div style={{ padding: 20 }}>
                        <form onSubmit={handleCreate}>
                            <div style={{ marginBottom: 14 }}>
                                <label style={label} htmlFor="new-title">Título *</label>
                                <input
                                    id="new-title"
                                    type="text"
                                    style={input}
                                    value={createForm.data.title}
                                    onChange={e => createForm.setData('title', e.target.value)}
                                    placeholder="Ex: Reunião Geral de TI"
                                    required
                                />
                                {createForm.errors.title && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.title}</p>
                                )}
                            </div>

                            <div style={{ marginBottom: 14 }}>
                                <label style={label} htmlFor="new-content">Conteúdo / Mensagem</label>
                                <textarea
                                    id="new-content"
                                    rows="4"
                                    style={{ ...input, resize: 'vertical' }}
                                    value={createForm.data.content}
                                    onChange={e => createForm.setData('content', e.target.value)}
                                    placeholder="Escreva a mensagem..."
                                />
                                {createForm.errors.content && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.content}</p>
                                )}
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, marginBottom: 14 }}>
                                <div>
                                    <label style={label} htmlFor="new-type">Tipo *</label>
                                    <select
                                        id="new-type"
                                        style={input}
                                        value={createForm.data.type_id}
                                        onChange={e => createForm.setData('type_id', e.target.value)}
                                        required
                                    >
                                        {types.map(t => (
                                            <option key={t.id} value={t.id}>{t.title}</option>
                                        ))}
                                    </select>
                                </div>
                                <div>
                                    <label style={label} htmlFor="new-status">Status *</label>
                                    <select
                                        id="new-status"
                                        style={input}
                                        value={createForm.data.status_id}
                                        onChange={e => createForm.setData('status_id', e.target.value)}
                                        required
                                    >
                                        {statuses.map(s => (
                                            <option key={s.id} value={s.id}>{s.status}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>

                            <div style={{ marginBottom: 14 }}>
                                <label style={label} htmlFor="new-scheduled">Agendamento (Opcional)</label>
                                <input
                                    id="new-scheduled"
                                    type="datetime-local"
                                    style={input}
                                    value={createForm.data.scheduled_at}
                                    onChange={e => createForm.setData('scheduled_at', e.target.value)}
                                />
                                {createForm.errors.scheduled_at && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.scheduled_at}</p>
                                )}
                            </div>

                            <div style={{ marginBottom: 18 }}>
                                <label style={label} htmlFor="new-users">Destinatários *</label>
                                <select
                                    id="new-users"
                                    multiple
                                    style={{ ...input, height: 120 }}
                                    value={createForm.data.users}
                                    onChange={e => {
                                        const values = Array.from(e.target.selectedOptions, option => parseInt(option.value));
                                        createForm.setData('users', values);
                                    }}
                                    required
                                >
                                    {users.map(u => (
                                        <option key={u.id} value={u.id}>
                                            {u.person?.name ? u.person.name : u.email}
                                        </option>
                                    ))}
                                </select>
                                <span style={helperText}>Segure Ctrl (ou Cmd) para selecionar múltiplos.</span>
                                {createForm.errors.users && (
                                    <p style={{ color: '#f87171', fontSize: 12, marginTop: 4 }}>{createForm.errors.users}</p>
                                )}
                            </div>

                            <button type="submit" style={btnPrimary} disabled={createForm.processing}>
                                {createForm.processing ? 'Enviando…' : 'Enviar Notificação'}
                            </button>
                        </form>
                    </div>
                </div>

                {/* ── Painel Direito: Abas e Lista de Notificações ── */}
                <div style={{ ...card }}>
                    {/* Tabs Header */}
                    <div style={tabHeader}>
                        <button
                            onClick={() => setActiveTab('not_readeds')}
                            style={tabButton(activeTab === 'not_readeds')}
                        >
                            📥 Não Lidas ({not_readeds.length})
                        </button>
                        <button
                            onClick={() => setActiveTab('readeds')}
                            style={tabButton(activeTab === 'readeds')}
                        >
                            📖 Lidas ({readeds.length})
                        </button>
                        <button
                            onClick={() => setActiveTab('sendeds')}
                            style={tabButton(activeTab === 'sendeds')}
                        >
                            📤 Enviadas ({sendeds.length})
                        </button>
                    </div>

                    <div style={{ padding: '16px 20px', borderBottom: '1px solid #334155', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                        <h3 style={{ margin: 0, fontSize: 14, fontWeight: 600, color: '#94a3b8' }}>
                            {activeTab === 'not_readeds' && 'Mensagens não lidas por você'}
                            {activeTab === 'readeds' && 'Mensagens lidas por você'}
                            {activeTab === 'sendeds' && 'Mensagens que você enviou'}
                        </h3>
                        <input
                            type="text"
                            placeholder="Buscar no título ou conteúdo..."
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            style={{ ...input, maxWidth: 260 }}
                        />
                    </div>

                    {filtered.length === 0 ? (
                        <div style={{ padding: 48, textAlign: 'center', color: '#64748b' }}>
                            <div style={{ fontSize: 36, marginBottom: 8 }}>💬</div>
                            <p style={{ margin: 0 }}>Nenhuma notificação encontrada nesta aba.</p>
                        </div>
                    ) : (
                        <div style={{ overflowX: 'auto' }}>
                            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                                <thead>
                                    <tr style={{ borderBottom: '1px solid #334155', background: '#0f172a50' }}>
                                        {['Título / Conteúdo', 'Tipo', 'Enviado por', 'Data', 'Ações'].map(h => (
                                            <th key={h} style={{ padding: '12px 16px', textAlign: 'left', color: '#94a3b8', fontSize: 11, fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em' }}>{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {filtered.map((notif, idx) => (
                                        <tr key={notif.id} style={{ borderBottom: '1px solid #0f172a', background: idx % 2 === 0 ? 'transparent' : '#ffffff02' }}>
                                            <td style={{ padding: '12px 16px', color: '#f1f5f9', maxWidth: 320 }}>
                                                <div style={{ fontWeight: 600, fontSize: 14 }}>{notif.title}</div>
                                                <div style={{ color: '#94a3b8', fontSize: 12, marginTop: 4, whiteSpace: 'pre-wrap' }}>{notif.content || 'Sem conteúdo.'}</div>
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1', fontSize: 13 }}>
                                                {notif.type?.title || 'Notificação'}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#cbd5e1', fontSize: 13 }}>
                                                {notif.sender?.name ? notif.sender.name : (notif.sender?.email || 'Sistema')}
                                            </td>
                                            <td style={{ padding: '12px 16px', color: '#94a3b8', fontSize: 12 }}>
                                                {new Date(notif.created_at).toLocaleString('pt-BR')}
                                            </td>
                                            <td style={{ padding: '12px 16px' }}>
                                                <div style={{ display: 'flex', gap: 6 }}>
                                                    {activeTab === 'not_readeds' && (
                                                        <button onClick={() => markAsRead(notif.id)} style={btnSuccess}>Lida</button>
                                                    )}
                                                    <button onClick={() => handleDelete(notif.id)} style={btnDanger}>Excluir</button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
