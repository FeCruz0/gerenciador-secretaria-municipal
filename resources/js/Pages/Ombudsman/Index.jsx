import React from 'react';

export default function Index({ ombudsmen, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Ouvidoria - Manifestações</h1>
            <p>Unidade: {unit?.name}</p>
            <ul>
                {ombudsmen.map((o) => (
                    <li key={o.id}>
                        <strong>Manifestação #{o.id}</strong> - {o.description || 'Sem descrição'}
                    </li>
                ))}
            </ul>
        </div>
    );
}
