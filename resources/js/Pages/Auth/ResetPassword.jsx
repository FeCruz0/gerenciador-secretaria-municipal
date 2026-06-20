import React from 'react';
import { useForm, Head } from '@inertiajs/react';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors } = useForm({
        token: token || '',
        email: email || '',
        password: '',
        password_confirmation: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/reset-password');
    };

    return (
        <div className="min-h-screen bg-slate-950 text-slate-100 flex items-stretch font-sans relative">
            <Head title="Resetar Senha" />

            {/* Logo Absoluta */}
            <div className="absolute top-8 left-8 z-20 flex items-center gap-2">
                <span className="font-bold text-lg text-slate-100 tracking-tight">SEMAS</span>
            </div>

            {/* Coluna Esquerda: Ilustração */}
            <div className="hidden lg:flex lg:w-2/3 items-center justify-center bg-slate-900 border-r border-slate-800/50 p-12 relative overflow-hidden">
                <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div className="relative z-10 w-full max-w-lg flex flex-col items-center">
                    <img 
                        className="w-4/5 h-auto max-h-[420px] object-contain drop-shadow-2xl" 
                        src="/images/pages/reset-password-v2.svg" 
                        alt="Reset password illustration" 
                    />
                    <div className="text-center mt-8 space-y-2">
                        <h3 className="text-xl font-bold text-slate-200">Redefinição de Senha</h3>
                        <p className="text-slate-400 text-sm max-w-sm">
                            Configure sua nova senha de acesso com segurança para restabelecer a conexão ao painel municipal.
                        </p>
                    </div>
                </div>
            </div>

            {/* Coluna Direita: Formulário */}
            <div className="w-full lg:w-1/3 flex items-center justify-center p-8 sm:p-12 md:p-16 bg-slate-950 relative">
                <div className="w-full max-w-sm space-y-6">
                    <div className="space-y-1">
                        <h2 className="text-2xl font-bold text-slate-100 tracking-tight">Redefinir Senha 🔒</h2>
                        <p className="text-slate-400 text-sm">
                            Crie uma nova senha de acesso diferente de senhas anteriores.
                        </p>
                    </div>

                    <form className="space-y-4" onSubmit={handleSubmit}>
                        <input type="hidden" name="token" value={data.token} />

                        {/* E-mail */}
                        <div className="space-y-1">
                            <label className="text-xs font-semibold text-slate-400 uppercase tracking-wider block" htmlFor="email">
                                E-mail
                            </label>
                            <input 
                                className={`w-full px-3.5 py-2.5 bg-slate-900 border ${errors.email ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-slate-800 focus:border-indigo-500 focus:ring-indigo-500'} rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 transition-all duration-200`}
                                id="email" 
                                type="email" 
                                name="email" 
                                value={data.email}
                                onChange={e => setData('email', e.target.value)}
                                placeholder="email@exemplo.com" 
                                required
                            />
                            {errors.email && (
                                <p className="text-xs text-red-400 mt-1">{errors.email}</p>
                            )}
                        </div>

                        {/* Nova Senha */}
                        <div className="space-y-1">
                            <label className="text-xs font-semibold text-slate-400 uppercase tracking-wider block" htmlFor="password">
                                Nova Senha
                            </label>
                            <input 
                                className={`w-full px-3.5 py-2.5 bg-slate-900 border ${errors.password ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-slate-800 focus:border-indigo-500 focus:ring-indigo-500'} rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 transition-all duration-200`}
                                id="password" 
                                type="password" 
                                name="password" 
                                value={data.password}
                                onChange={e => setData('password', e.target.value)}
                                placeholder="••••••••" 
                                autoFocus
                                required
                            />
                            {errors.password && (
                                <p className="text-xs text-red-400 mt-1">{errors.password}</p>
                            )}
                        </div>

                        {/* Confirmar Senha */}
                        <div className="space-y-1">
                            <label className="text-xs font-semibold text-slate-400 uppercase tracking-wider block" htmlFor="password_confirmation">
                                Confirmar Senha
                            </label>
                            <input 
                                className={`w-full px-3.5 py-2.5 bg-slate-900 border ${errors.password_confirmation ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-slate-800 focus:border-indigo-500 focus:ring-indigo-500'} rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 transition-all duration-200`}
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                value={data.password_confirmation}
                                onChange={e => setData('password_confirmation', e.target.value)}
                                placeholder="••••••••" 
                                required
                            />
                            {errors.password_confirmation && (
                                <p className="text-xs text-red-400 mt-1">{errors.password_confirmation}</p>
                            )}
                        </div>

                        <button 
                            className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg font-semibold shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                            type="submit"
                            disabled={processing}
                        >
                            {processing ? 'Redefinindo...' : 'Redefinir Senha'}
                        </button>
                    </form>

                    <p className="text-center text-sm">
                        <a href="/login" className="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                            ← Voltar para o Login
                        </a>
                    </p>
                    
                    {/* Logo Code PDF */}
                    <div className="pt-6 border-t border-slate-900 flex justify-center">
                        <img 
                            src="/images/logo/logo-code-pdf.png" 
                            className="h-8 w-auto object-contain opacity-40"  
                            alt="logo code pdf" 
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}
