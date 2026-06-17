import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

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
        <div className="auth-wrapper auth-cover">
            <Head title="Verificar E-mail" />
            <div className="auth-inner row m-0">
                {/* Brand logo*/}
                <a className="brand-logo" href="#">
                    {/* Pode adicionar logo caso necessário */}
                </a>
                {/* /Brand logo*/}

                {/* Left Text*/}
                <div className="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div className="w-100 d-lg-flex align-items-center justify-content-center px-5">
                        <img 
                            className="img-fluid" 
                            src="/images/illustration/verify-email-illustration.svg" 
                            alt="Verify email illustration" 
                        />
                    </div>
                </div>
                {/* /Left Text*/}

                {/* Verify Email Cover */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 className="card-title fw-bold mb-1">Verifique seu e-mail ✉️</h2>
                        <p className="card-text mb-2">
                            Um link de ativação foi enviado para seu endereço de e-mail cadastrado. Por favor, acesse o link enviado para ativar sua conta e continuar.
                        </p>

                        {verificationLinkSent && (
                            <div className="alert alert-success p-1 mb-2" role="alert">
                                Um novo link de verificação foi enviado para o seu endereço de e-mail.
                            </div>
                        )}

                        <form onSubmit={handleResend} className="mt-2">
                            <button 
                                className="btn btn-primary w-100" 
                                type="submit" 
                                disabled={processing}
                            >
                                {processing ? 'Reenviando...' : 'Reenviar e-mail de verificação'}
                            </button>
                        </form>

                        <form onSubmit={handleLogout} className="mt-1">
                            <button 
                                className="btn btn-outline-danger w-100" 
                                type="submit"
                            >
                                Sair da Conta
                            </button>
                        </form>

                        <div className="col-12 col-sm-8 col-md-6 col-lg-12 pt-4 text-center">
                            <img 
                                src="/images/logo/logo-code-pdf.png" 
                                style={{ width: '50%' }} 
                                className="logo-gmac"  
                                alt="logo code pdf" 
                            />
                        </div>
                    </div>
                </div>
                {/* /Verify Email Cover */}
            </div>
        </div>
    );
}
