import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/register', {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="auth-wrapper auth-cover">
            <Head title="Criar Conta" />
            <div className="auth-inner row m-0">

                {/* Ilustração esquerda */}
                <div className="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div className="w-100 d-lg-flex align-items-center justify-content-center px-5">
                        <img
                            className="img-fluid"
                            src="/images/pages/register-v2.svg"
                            alt="Ilustração de cadastro"
                            style={{ width: '70%' }}
                        />
                    </div>
                </div>
                {/* /Ilustração esquerda */}

                {/* Formulário de Cadastro */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">

                        <h2 className="card-title fw-bold mb-1">Criar Conta</h2>
                        <p className="card-text mb-2">
                            Preencha os dados abaixo para solicitar acesso ao sistema.
                        </p>

                        <form className="auth-register-form mt-2" onSubmit={handleSubmit}>

                            {/* Nome */}
                            <div className="mb-1">
                                <label className="form-label" htmlFor="name">Nome completo</label>
                                <input
                                    className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                                    id="name"
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    onChange={e => setData('name', e.target.value)}
                                    placeholder="Seu nome"
                                    autoFocus
                                    tabIndex="1"
                                    required
                                />
                                {errors.name && (
                                    <div className="invalid-feedback">{errors.name}</div>
                                )}
                            </div>

                            {/* E-mail */}
                            <div className="mb-1">
                                <label className="form-label" htmlFor="email">E-mail</label>
                                <input
                                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    onChange={e => setData('email', e.target.value)}
                                    placeholder="email@exemplo.com"
                                    tabIndex="2"
                                    required
                                />
                                {errors.email && (
                                    <div className="invalid-feedback">{errors.email}</div>
                                )}
                            </div>

                            {/* Senha */}
                            <div className="mb-1">
                                <label className="form-label" htmlFor="password">Senha</label>
                                <div className="input-group input-group-merge form-password-toggle">
                                    <input
                                        className={`form-control form-control-merge ${errors.password ? 'is-invalid' : ''}`}
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        onChange={e => setData('password', e.target.value)}
                                        placeholder="Mínimo 8 caracteres"
                                        tabIndex="3"
                                        required
                                    />
                                </div>
                                {errors.password && (
                                    <div className="text-danger mt-25"><small>{errors.password}</small></div>
                                )}
                            </div>

                            {/* Confirmar Senha */}
                            <div className="mb-1">
                                <label className="form-label" htmlFor="password_confirmation">Confirmar Senha</label>
                                <div className="input-group input-group-merge form-password-toggle">
                                    <input
                                        className={`form-control form-control-merge ${errors.password_confirmation ? 'is-invalid' : ''}`}
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        value={data.password_confirmation}
                                        onChange={e => setData('password_confirmation', e.target.value)}
                                        placeholder="Repita a senha"
                                        tabIndex="4"
                                        required
                                    />
                                </div>
                                {errors.password_confirmation && (
                                    <div className="text-danger mt-25"><small>{errors.password_confirmation}</small></div>
                                )}
                            </div>

                            <button
                                className="btn btn-primary w-100 mt-1"
                                tabIndex="5"
                                type="submit"
                                disabled={processing}
                            >
                                {processing ? 'Criando conta...' : 'Criar Conta'}
                            </button>
                        </form>

                        <p className="text-center mt-2">
                            <span>Já tem uma conta? </span>
                            <a href="/login">
                                <span>Entrar</span>
                            </a>
                        </p>

                    </div>
                </div>
                {/* /Formulário de Cadastro */}

            </div>
        </div>
    );
}
