import React from 'react';

export default function Index({ news, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Notícias</h1>
            <p>Unidade: {unit?.name}</p>
            <ul>
                {news.map((item) => (
                    <li key={item.id}>
                        <strong>{item.title}</strong> (Status: {item.status})
                    </li>
                ))}
            </ul>
        </div>
    );
}
