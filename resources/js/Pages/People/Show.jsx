import React from 'react';

export default function Show({ user, audits, occupations }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Detalhes da Pessoa: {user?.name}</h1>
            <p>E-mail: {user?.email}</p>
        </div>
    );
}
