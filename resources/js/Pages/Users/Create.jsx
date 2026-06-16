import React from 'react';

export default function Create({ roles }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Criar Usuário</h1>
            <p>Selecione um perfil de acesso:</p>
            <ul>
                {Object.keys(roles).map((key) => <li key={key}>{roles[key]}</li>)}
            </ul>
        </div>
    );
}
