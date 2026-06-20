import React from 'react';
import { useForm, Head } from '@inertiajs/react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm();

    const handleResend = (e) => {
        e.preventDefault();
        post('/email/verification-notification');
    };

    const handleLogout = (e) => {
        e.preventDefault();
        post('/logout');
    };

    const verificationLinkSent = status === 'verification-link-sent';

    return (
        <div className="min-h-screen bg-slate-950 text-slate-100 flex items-stretch font-sans relative">
            <Head title="Verificar E-mail" />

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
                        src="/images/illustration/verify-email-illustration.svg" 
                        alt="Verify email illustration" 
                    />
                    <div className="text-center mt-8 space-y-2">
                        <h3 className="text-xl font-bold text-slate-200">Verificação de Conta</h3>
                        <p className="text-slate-400 text-sm max-w-sm">
                            Confirme seu endereço de e-mail clicando no link de ativação enviado para garantir o acesso seguro à plataforma.
                        </p>
                    </div>
                </div>
            </div>

            {/* Coluna Direita: Formulário */}
            <div className="w-full lg:w-1/3 flex items-center justify-center p-8 sm:p-12 md:p-16 bg-slate-950 relative">
                <div className="w-full max-w-sm space-y-6">
                    <div className="space-y-1">
                        <h2 className="text-2xl font-bold text-slate-100 tracking-tight">Verifique seu e-mail ✉️</h2>
                        <p className="text-slate-400 text-sm">
                            Um link de ativação foi enviado para seu endereço de e-mail cadastrado. Por favor, acesse o link enviado para ativar sua conta e continuar.
                        </p>
                    </div>

                    {verificationLinkSent && (
                        <div className="p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm" role="alert">
                            Um novo link de verificação foi enviado para o seu endereço de e-mail.
                        </div>
                    )}

                    <div className="space-y-3">
                        <form onSubmit={handleResend}>
                            <button 
                                className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg font-semibold shadow-md shadow-indigo-600/20 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none" 
                                type="submit" 
                                disabled={processing}
                            >
                                {processing ? 'Reenviando...' : 'Reenviar e-mail de verificação'}
                            </button>
                        </form>

                        <form onSubmit={handleLogout}>
                            <button 
                                className="w-full py-2.5 bg-transparent hover:bg-red-500/10 text-red-400 hover:text-red-300 border border-red-500/30 hover:border-red-500/50 rounded-lg font-semibold transition-all duration-200" 
                                type="submit"
                            >
                                Sair da Conta
                            </button>
                        </form>
                    </div>

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
