import React from 'react';

export default function Show({ news, tags, categories, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Visualizar Notícia: {news?.title}</h1>
            <p>Unidade: {unit?.name}</p>
            <div dangerouslySetInnerHTML={{ __html: news?.content }} />
        </div>
    );
}
