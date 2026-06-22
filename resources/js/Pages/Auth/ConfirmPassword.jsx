import React from 'react';
import { useForm, Head } from '@inertiajs/react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/confirm-password', {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="min-h-screen bg-slate-950 text-slate-100 flex items-stretch font-sans relative">
            <Head title="Confirmar Senha" />

            {/* Logo Absoluta */}
            <div className="absolute top-8 left-8 z-20 flex items-center gap-2">
                <span className="font-bold text-lg text-slate-100 tracking-tight">GESEM</span>
            </div>

            {/* Coluna Esquerda: Ilustração */}
            <div className="hidden lg:flex lg:w-2/3 items-center justify-center bg-slate-900 border-r border-slate-800/50 p-12 relative overflow-hidden">
                <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div className="relative z-10 w-full max-w-lg flex flex-col items-center">
                    <img 
                        className="w-4/5 h-auto max-h-[420px] object-contain drop-shadow-2xl" 
                        src="/images/pages/reset-password-v2.svg" 
                        alt="Confirm password illustration" 
                    />
                    <div className="text-center mt-8 space-y-2">
                        <h3 className="text-xl font-bold text-slate-200">Área Segura</h3>
                        <p className="text-slate-400 text-sm max-w-sm">
                            Por razões de segurança, confirme sua senha de acesso para poder prosseguir.
                        </p>
                    </div>
                </div>
            </div>

            {/* Coluna Direita: Formulário */}
            <div className="w-full lg:w-1/3 flex items-center justify-center p-8 sm:p-12 md:p-16 bg-slate-950 relative">
                <div className="w-full max-w-sm space-y-6">
                    <div className="space-y-1">
                        <h2 className="text-2xl font-bold text-slate-100 tracking-tight">Confirmar Senha</h2>
                        <p className="text-slate-400 text-sm">
                            Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
                        </p>
                    </div>

                    <form className="space-y-4" onSubmit={handleSubmit}>
                        <div className="space-y-1">
                            <label className="text-xs font-semibold text-slate-400 uppercase tracking-wider block" htmlFor="password">
                                Senha
                            </label>
                            <input
                                className={`w-full px-3.5 py-2.5 bg-slate-900 border ${errors.password ? 'border-red-500/50 focus:border-red-500 focus:ring-red-500' : 'border-slate-800 focus:border-indigo-500 focus:ring-indigo-500'} rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 transition-all duration-200`}
                                type="password"
                                name="password"
                                id="password"
                                value={data.password}
                                onChange={e => setData('password', e.target.value)}
                                placeholder="••••••••"
                                required
                                autoFocus
                            />
                            {errors.password && (
                                <p className="text-xs text-red-400 mt-1">{errors.password}</p>
                            )}
                        </div>

                        <button 
                            className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg font-semibold shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                            type="submit" 
                            disabled={processing}
                        >
                            {processing ? 'Confirmando...' : 'Confirmar'}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
