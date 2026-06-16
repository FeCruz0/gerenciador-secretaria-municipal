import React from 'react';

export default function ReportIndex({ ombudsman, unit }) {
    return (
        <div style={{ padding: '2rem', fontFamily: 'sans-serif' }}>
            <h1>Relatórios da Ouvidoria</h1>
            <p>Unidade: {unit?.name}</p>
        </div>
    );
}
