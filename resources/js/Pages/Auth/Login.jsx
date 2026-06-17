import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

export default function Login({ unit }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <div className="auth-wrapper auth-cover">
            <Head title="Página de LOGIN" />
            <div className="auth-inner row m-0">
                {/* Brand logo*/}
                <a className="brand-logo" href="#">
                    {unit?.logo && (
                        <img 
                            src={`/storage/images/units/${unit.logo}`} 
                            className="logo-gmac"  
                            alt="logo" 
                            style={{ width: '10%' }} 
                        />
                    )}
                </a>
                {/* /Brand logo*/}

                {/* Left Text*/}
                <div className="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div className="w-100 d-lg-flex align-items-center justify-content-center px-5">
                        <img 
                            className="img-fluid" 
                            src="/images/illustration/create-account.svg" 
                            alt="Login Illustration" 
                            style={{ width: '40%' }} 
                        />
                    </div>
                </div>
                {/* /Left Text*/}

                {/* Login Form */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 className="card-title fw-bold mb-1">
                            Seja bem-vindo ao Sistema do {unit?.name || ''}!
                        </h2>
                        <p className="card-text mb-2">
                            Por favor entre com sua conta para poder acessar o painel de controle
                        </p>

                        <form className="auth-login-form mt-2" onSubmit={handleSubmit}>
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
                                <div className="d-flex justify-content-between">
                                    <label className="form-label" htmlFor="password">Senha</label>
                                    <a href="/forgot-password">
                                        <small>Esqueceu a Senha?</small>
                                    </a>
                                </div>
                                <div className="input-group input-group-merge form-password-toggle">
                                    <input 
                                        className={`form-control form-control-merge ${errors.password ? 'is-invalid' : ''}`}
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        value={data.password}
                                        onChange={e => setData('password', e.target.value)}
                                        placeholder="············" 
                                        tabIndex="2" 
                                        required
                                    />
                                </div>
                                {errors.password && (
                                    <div className="text-danger mt-25"><small>{errors.password}</small></div>
                                )}
                            </div>

                            <div className="mb-1">
                                <div className="form-check">
                                    <input 
                                        className="form-check-input" 
                                        id="remember_me" 
                                        type="checkbox" 
                                        checked={data.remember}
                                        onChange={e => setData('remember', e.target.checked)}
                                        tabIndex="3" 
                                    />
                                    <label className="form-check-label" htmlFor="remember_me"> Lembrar</label>
                                </div>
                            </div>

                            <button 
                                className="btn btn-primary w-100" 
                                tabIndex="4"
                                disabled={processing}
                            >
                                {processing ? 'Entrando...' : 'Entrar'}
                            </button>
                        </form>


                    </div>
                </div>
                {/* /Login Form */}
            </div>
        </div>
    );
}
