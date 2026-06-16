import React from 'react';

export default function Index({ users, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Pessoas</h1>
            <p>Unidade: {unit?.name}</p>
            <ul>
                {users.map((u) => (
                    <li key={u.id}>
                        {u.person?.full_name || 'Usuário sem Pessoa Associada'} ({u.email})
                    </li>
                ))}
            </ul>
        </div>
    );
}
