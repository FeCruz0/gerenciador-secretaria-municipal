import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { ShieldAlert, FileSearch, ServerCrash, Construction, ArrowLeft } from 'lucide-react';

export default function Error({ status }) {
    const errorConfigs = {
        403: {
            title: 'Acesso Negado',
            description: 'Desculpe, você não possui as permissões necessárias para acessar esta área da aplicação.',
            icon: ShieldAlert,
            color: 'text-red-400 bg-red-500/10 border-red-500/20'
        },
        404: {
            title: 'Página Não Encontrada',
            description: 'A página que você está procurando não existe, foi removida ou o endereço está incorreto.',
            icon: FileSearch,
            color: 'text-indigo-400 bg-indigo-500/10 border-indigo-500/20'
        },
        500: {
            title: 'Erro no Servidor',
            description: 'Ocorreu um problema inesperado em nossos servidores. Já estamos trabalhando para corrigi-lo.',
            icon: ServerCrash,
            color: 'text-amber-400 bg-amber-500/10 border-amber-500/20'
        },
        503: {
            title: 'Sistema em Manutenção',
            description: 'Estamos realizando melhorias programadas na plataforma. Voltaremos a funcionar em breve.',
            icon: Construction,
            color: 'text-teal-400 bg-teal-500/10 border-teal-500/20'
        }
    };

    const config = errorConfigs[status] || {
        title: 'Algo deu errado',
        description: 'Ocorreu um erro desconhecido. Por favor, tente novamente.',
        icon: ShieldAlert,
        color: 'text-slate-400 bg-slate-500/10 border-slate-500/20'
    };

    const IconComponent = config.icon;

    return (
        <div className="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center font-sans p-6 relative overflow-hidden">
            {/* Decoração de fundo com Glow desfoque */}
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div className="w-full max-w-md text-center space-y-6 relative z-10">
                {/* Ícone com animação sutil e cores baseadas no tipo de erro */}
                <div className="flex justify-center">
                    <div className={`h-24 w-24 rounded-2xl border flex items-center justify-center shadow-lg ${config.color} animate-pulse`}>
                        <IconComponent className="h-12 w-12" />
                    </div>
                </div>

                {/* Código de Status e Título */}
                <div className="space-y-1">
                    <span className="text-xs font-semibold text-indigo-400 tracking-widest uppercase block">Erro {status}</span>
                    <h1 className="text-3xl font-extrabold text-slate-100 tracking-tight">{config.title}</h1>
                </div>

                {/* Descrição amigável */}
                <p className="text-sm text-slate-400 leading-relaxed max-w-sm mx-auto">
                    {config.description}
                </p>

                {/* Botão de retorno */}
                <div className="pt-2">
                    <Link 
                        href="/dashboard"
                        className="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold rounded-lg shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition-all duration-200"
                    >
                        <ArrowLeft className="h-4 w-4" />
                        <span>Voltar para o Painel</span>
                    </Link>
                </div>

                {/* Footer Assinatura */}
                <div className="pt-8 border-t border-slate-900 flex justify-center">
                    <img 
                        src="/images/logo/logo-code-pdf.png" 
                        className="h-8 w-auto object-contain opacity-30"  
                        alt="logo code pdf" 
                    />
                </div>
            </div>
        </div>
    );
}
