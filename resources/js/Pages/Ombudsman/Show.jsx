import React from 'react';

export default function Show({ ombudsman, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Manifestação #{ombudsman?.id}</h1>
            <p>Unidade: {unit?.name}</p>
            <p>{ombudsman?.description}</p>
        </div>
    );
}
