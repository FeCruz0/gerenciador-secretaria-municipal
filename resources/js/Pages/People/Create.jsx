import React from 'react';

export default function Create({ unit, occupations, units, departaments }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Cadastrar Nova Pessoa</h1>
            <p>Unidade Administrativa: {unit?.name}</p>
        </div>
    );
}
