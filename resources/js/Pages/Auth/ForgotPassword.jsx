import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/forgot-password');
    };

    return (
        <div className="auth-wrapper auth-cover">
            <Head title="Esqueceu a senha" />
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
                            src="/images/pages/forgot-password-v2.svg" 
                            alt="Forgot password illustration" 
                        />
                    </div>
                </div>
                {/* /Left Text*/}

                {/* Forgot Password Form */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 className="card-title fw-bold mb-1">Esqueceu sua Senha? 🔒</h2>
                        <p className="card-text mb-2">
                            Entre com seu e-mail e nós enviaremos as instruções para alterar sua Senha.
                        </p>

                        {status && (
                            <div className="alert alert-success p-1 mb-2" role="alert">
                                {status}
                            </div>
                        )}

                        <form className="auth-forgot-password-form mt-2" onSubmit={handleSubmit}>
                            <div className="mb-1">
                                <label className="form-label" htmlFor="email">E-mail</label>
                                <input 
                                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value={data.email}
                                    onChange={e => setData('email', e.target.value)}
                                    placeholder="email@example.com" 
                                    autoFocus
                                    tabIndex="1"
                                    required
                                />
                                {errors.email && (
                                    <div className="invalid-feedback">{errors.email}</div>
                                )}
                            </div>
                            <button 
                                className="btn btn-primary w-100" 
                                tabIndex="2" 
                                type="submit"
                                disabled={processing}
                            >
                                {processing ? 'Enviando...' : 'Enviar e-mail'}
                            </button>
                        </form>

                        <p className="text-center mt-2">
                            <a href="/login">
                                &lt; Voltar para Login
                            </a>
                        </p>
                        
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
                {/* /Forgot Password Form */}
            </div>
        </div>
    );
}
