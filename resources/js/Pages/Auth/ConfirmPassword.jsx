import React from 'react';
import { useForm, Head } from '@inertiajs/inertia-react';

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
        <div className="auth-wrapper auth-cover">
            <Head title="Confirmar Senha" />
            <div className="auth-inner row m-0">
                {/* Left Text (Vazio ou Ilustração) */}
                <div className="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div className="w-100 d-lg-flex align-items-center justify-content-center px-5">
                        <img 
                            className="img-fluid" 
                            src="/images/pages/reset-password-v2.svg" 
                            alt="Confirm password illustration" 
                        />
                    </div>
                </div>
                {/* /Left Text*/}

                {/* Confirm Password Form */}
                <div className="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div className="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 className="mt-2">Confirmar Senha</h2>
                        <p className="card-text mb-75">
                            Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
                        </p>

                        <form onSubmit={handleSubmit} className="mt-2">
                            <div className="col-12 mb-1">
                                <label className="form-label" htmlFor="password">Senha</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                    required
                                    autoFocus
                                />
                                {errors.password && (
                                    <div className="invalid-feedback">{errors.password}</div>
                                )}
                            </div>
                            <button 
                                className="btn btn-primary w-100 mt-2" 
                                type="submit" 
                                disabled={processing}
                            >
                                {processing ? 'Confirmando...' : 'Confirmar'}
                            </button>
                        </form>
                    </div>
                </div>
                {/* /Confirm Password Form */}
            </div>
        </div>
    );
}
