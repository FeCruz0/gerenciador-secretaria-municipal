import React from 'react';

export default function Edit({ user, roles }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Editar Usuário: {user?.name}</h1>
            <p>E-mail: {user?.email}</p>
        </div>
    );
}
