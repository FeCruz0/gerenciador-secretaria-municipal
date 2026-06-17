import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

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
        <div className="auth-wrapper auth-cover">
            <Head title="Resetar Senha" />
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
                            src="/images/pages/reset-password-v2.svg" 
                            alt="Reset password illustration" 
                        />
                    </div>
                </div>
                {/* /Left Text*/}

                {/* Reset Password Form */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 className="card-title fw-bold mb-1">Alterar Senha 🔒</h2>
                        <p className="card-text mb-2">
                            É recomendado que a nova Senha seja diferente de senhas anteriores.
                        </p>

                        <form className="auth-reset-password-form mt-2" onSubmit={handleSubmit}>
                            <input type="hidden" name="token" value={data.token} />

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

                            <div className="mb-1">
                                <label className="form-label" htmlFor="password">Nova Senha</label>
                                <input 
                                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                    placeholder="············" 
                                    tabIndex="2"
                                    required
                                />
                                {errors.password && (
                                    <div className="invalid-feedback">{errors.password}</div>
                                )}
                            </div>

                            <div className="mb-1">
                                <label className="form-label" htmlFor="password_confirmation">Confirmar Senha</label>
                                <input 
                                    className={`form-control ${errors.password_confirmation ? 'is-invalid' : ''}`}
                                    id="password_confirmation" 
                                    type="password" 
                                    name="password_confirmation" 
                                    value={data.password_confirmation}
                                    onChange={e => setData('password_confirmation', e.target.value)}
                                    placeholder="············" 
                                    tabIndex="3"
                                    required
                                />
                                {errors.password_confirmation && (
                                    <div className="invalid-feedback">{errors.password_confirmation}</div>
                                )}
                            </div>

                            <button 
                                className="btn btn-primary w-100" 
                                tabIndex="4" 
                                type="submit"
                                disabled={processing}
                            >
                                {processing ? 'Confirmando...' : 'Confirmar alteração'}
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
                {/* /Reset Password Form */}
            </div>
        </div>
    );
}
