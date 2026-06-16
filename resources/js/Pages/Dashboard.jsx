import React from 'react';
import AdminLayout from '../Components/Layout/AdminLayout';

export default function Dashboard({ auth, unit }) {
    const user = auth?.user;

    return (
        <AdminLayout>
            {/* Dashboard Analytics Start */}
            <section id="dashboard-analytics">

                {/* Stats row — hidden (mantido igual ao original) */}
                <div className="row match-height" hidden>
                    <div className="col-lg-3 col-sm-6 col-12">
                        <div className="card">
                            <div className="card-header">
                                <div>
                                    <h2 className="fw-bolder mb-0">00</h2>
                                    <p className="card-text">RAS Abertos</p>
                                </div>
                                <div className="avatar bg-light-primary p-50 m-0">
                                    <div className="avatar-content">
                                        <i data-feather="book-open" className="font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-3 col-sm-6 col-12">
                        <div className="card">
                            <div className="card-header">
                                <div>
                                    <h2 className="fw-bolder mb-0">00</h2>
                                    <p className="card-text">Total de RAS</p>
                                </div>
                                <div className="avatar bg-light-success p-50 m-0">
                                    <div className="avatar-content">
                                        <i data-feather="book" className="font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-3 col-sm-6 col-12">
                        <div className="card">
                            <div className="card-header">
                                <div>
                                    <h2 className="fw-bolder mb-0">0</h2>
                                    <p className="card-text">Notificações</p>
                                </div>
                                <div className="avatar bg-light-danger p-50 m-0">
                                    <div className="avatar-content">
                                        <i data-feather="bell" className="font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="row match-height">
                    {/* Profile Card — igual ao original */}
                    <div className="col-lg-4 col-md-6 col-12">
                        <div className="card card-profile">
                            <img
                                src="/images/banner/banner.png"
                                className="img-fluid card-img-top"
                                alt="Profile Cover Photo"
                            />
                            <div className="card-body">
                                <div className="profile-image-wrapper">
                                    <div className="profile-image">
                                        <div className="avatar">
                                            <img
                                                src={
                                                    user?.profile_photo_path
                                                        ? `/${user.profile_photo_path}`
                                                        : '/images/portrait/small/avatar-icon.png'
                                                }
                                                alt="Profile Picture"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <h3>{user?.name}</h3>
                                <span className="badge badge-light-primary profile-badge">
                                    {user?.occupations?.[0]?.title ?? 'Desenvolvedor'}
                                </span>
                                <hr className="mb-2" />
                            </div>
                        </div>
                    </div>
                    {/*/ Profile Card */}

                    {/* Developer Meetup Card — hidden (mantido igual ao original) */}
                    <div className="col-lg-4 col-md-6 col-12" hidden>
                        <div className="card card-developer-meetup">
                            <div className="meetup-img-wrapper rounded-top text-center">
                                <img src="/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                            </div>
                            <div className="card-body">
                                <div className="meetup-header d-flex align-items-center">
                                    <div className="meetup-day">
                                        <h3 className="mb-0">{new Date().getDate()}</h3>
                                    </div>
                                    <div className="my-auto">
                                        <h4 className="card-title mb-25">RAS do dia</h4>
                                        <p className="card-text mb-0">apenas os RAS do dia de hoje</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/*/ Developer Meetup Card */}

                    {/* Employee Task Card — hidden (mantido igual ao original) */}
                    <div className="col-lg-4 col-md-6 col-12" hidden>
                        <div className="card card-employee-task">
                            <div className="card-header">
                                <h4 className="card-title">Lista de RAS</h4>
                                <a href="#">
                                    <i data-feather="calendar" className="font-medium-3 cursor-pointer"></i>
                                </a>
                            </div>
                            <div className="card-body"></div>
                        </div>
                    </div>
                    {/*/ Employee Task Card */}
                </div>
            </section>
            {/* Dashboard Analytics end */}
        </AdminLayout>
    );
}
