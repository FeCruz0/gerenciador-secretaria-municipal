import React from 'react';

export default function Create({ tags, categories, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Criar Nova Notícia</h1>
            <p>Unidade: {unit?.name}</p>
            <div>
                <h3>Categorias</h3>
                <ul>
                    {categories.map((c) => <li key={c.id}>{c.title}</li>)}
                </ul>
            </div>
        </div>
    );
}
