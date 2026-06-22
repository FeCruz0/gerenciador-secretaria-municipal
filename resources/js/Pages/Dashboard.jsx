import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '../Components/Layout/AdminLayout';
import { 
    User, 
    Building2, 
    FileText, 
    Settings, 
    ArrowRight, 
    Plus, 
    Clock, 
    Calendar,
    Phone,
    Mail,
    MapPin
} from 'lucide-react';

export default function Dashboard({ auth, unit }) {
    const user = auth?.user;
    const today = new Date().toLocaleDateString('pt-BR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const formattedDate = today.charAt(0).toUpperCase() + today.slice(1);

    return (
        <AdminLayout title="Painel Administrativo">
            <Head title="Painel" />

            <div className="space-y-6">
                {/* Boas-vindas Header */}
                <div className="bg-gradient-to-r from-indigo-950 to-slate-900 border border-indigo-500/10 rounded-xl p-6 shadow-lg relative overflow-hidden">
                    <div className="absolute right-0 top-0 -mt-4 -mr-4 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
                    <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 className="text-2xl font-bold text-slate-100">
                                Olá, {user?.name ? user.name.split(' ')[0] : 'Administrador'}! 👋
                            </h1>
                            <p className="text-slate-400 mt-1 text-sm">
                                Bem-vindo de volta ao sistema de gerenciamento municipal. Veja o resumo das atividades hoje.
                            </p>
                        </div>
                        <div className="flex items-center gap-2 bg-slate-900/60 border border-slate-800 rounded-lg px-4 py-2 self-start md:self-auto">
                            <Calendar className="h-4 w-4 text-indigo-400 shrink-0" />
                            <span className="text-xs font-medium text-slate-300">{formattedDate}</span>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Coluna 1: Profile Card */}
                    <div className="lg:col-span-1">
                        <div className="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-xl flex flex-col h-full">
                            {/* Card Cover */}
                            <div className="h-32 bg-gradient-to-tr from-indigo-950 via-indigo-900/40 to-slate-950 relative">
                                <img
                                    src="/images/banner/banner.png"
                                    className="w-full h-full object-cover opacity-30"
                                    alt="Capa de Perfil"
                                    onError={(e) => {
                                        e.target.style.display = 'none';
                                    }}
                                />
                                <div className="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                            </div>

                            {/* Card Profile Image */}
                            <div className="px-6 -mt-12 relative z-10 flex flex-col items-center">
                                <div className="h-24 w-24 rounded-full border-4 border-slate-900 bg-slate-950 shadow-xl overflow-hidden flex items-center justify-center text-slate-500">
                                    {user?.profile_photo_path ? (
                                        <img
                                            src={`/${user.profile_photo_path}`}
                                            alt={user.name}
                                            className="h-full w-full object-cover"
                                        />
                                    ) : (
                                        <User className="h-10 w-10 text-indigo-400" />
                                    )}
                                </div>
                                <h3 className="text-lg font-bold text-slate-100 mt-3 text-center">
                                    {user?.name}
                                </h3>
                                <span className="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                    {user?.occupations?.[0]?.title ?? 'Administrador'}
                                </span>
                            </div>

                            {/* Divider */}
                            <hr className="border-slate-800 my-5 mx-6" />

                            {/* User Details */}
                            <div className="px-6 pb-6 space-y-4 flex-1">
                                <h4 className="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Informações do Usuário
                                </h4>
                                <div className="space-y-3">
                                    <div className="flex items-center gap-3 text-sm">
                                        <Mail className="h-4 w-4 text-slate-400 shrink-0" />
                                        <span className="text-slate-300 truncate" title={user?.email}>{user?.email}</span>
                                    </div>
                                    <div className="flex items-center gap-3 text-sm">
                                        <Clock className="h-4 w-4 text-slate-400 shrink-0" />
                                        <span className="text-slate-300">
                                            Membro desde: {user?.created_at ? new Date(user.created_at).toLocaleDateString('pt-BR') : '—'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Coluna 2 e 3: Informações da Unidade e Ações Rápidas */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Card da Unidade */}
                        {unit && (
                            <div className="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-4">
                                <div className="flex items-center gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                                        <Building2 className="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h3 className="font-bold text-slate-100 text-lg">{unit.name}</h3>
                                        <p className="text-xs text-indigo-400 font-semibold uppercase tracking-wider">{unit.sigla || 'GESEM'}</p>
                                    </div>
                                </div>

                                <hr className="border-slate-800" />

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {unit.email && (
                                        <div className="flex items-center gap-3 text-sm">
                                            <Mail className="h-4 w-4 text-indigo-400 shrink-0" />
                                            <div>
                                                <p className="text-xs text-slate-500">E-mail de Contato</p>
                                                <p className="text-slate-300">{unit.email}</p>
                                            </div>
                                        </div>
                                    )}
                                    {unit.phone && (
                                        <div className="flex items-center gap-3 text-sm">
                                            <Phone className="h-4 w-4 text-indigo-400 shrink-0" />
                                            <div>
                                                <p className="text-xs text-slate-500">Telefone</p>
                                                <p className="text-slate-300">{unit.phone}</p>
                                            </div>
                                        </div>
                                    )}
                                    {unit.address && (
                                        <div className="flex items-center gap-3 text-sm md:col-span-2">
                                            <MapPin className="h-4 w-4 text-indigo-400 shrink-0" />
                                            <div>
                                                <p className="text-xs text-slate-500">Endereço</p>
                                                <p className="text-slate-300">{unit.address}</p>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* Ações Rápidas */}
                        <div className="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-4">
                            <h3 className="text-lg font-bold text-slate-100">Atalhos Rápidos</h3>
                            <p className="text-sm text-slate-400">Acesse facilmente as principais ferramentas do painel administrativo.</p>
                            
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                <Link 
                                    href={route('licitacoes.create')}
                                    className="flex items-center justify-between p-4 rounded-xl bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/30 transition-all group"
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="p-2.5 rounded-lg bg-indigo-500/10 text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <Plus className="h-4 w-4" />
                                        </div>
                                        <div className="text-left">
                                            <span className="font-semibold text-sm text-slate-200 block">Nova Licitação</span>
                                            <span className="text-xs text-slate-500">Adicionar processo de licitação</span>
                                        </div>
                                    </div>
                                    <ArrowRight className="h-4 w-4 text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" />
                                </Link>

                                <Link 
                                    href={route('relatorio_de_gestao.create')}
                                    className="flex items-center justify-between p-4 rounded-xl bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/30 transition-all group"
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="p-2.5 rounded-lg bg-indigo-500/10 text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <FileText className="h-4 w-4" />
                                        </div>
                                        <div className="text-left">
                                            <span className="font-semibold text-sm text-slate-200 block">Novo Relatório</span>
                                            <span className="text-xs text-slate-500">Criar relatório de gestão</span>
                                        </div>
                                    </div>
                                    <ArrowRight className="h-4 w-4 text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" />
                                </Link>

                                <Link 
                                    href={route('noticias.index')}
                                    className="flex items-center justify-between p-4 rounded-xl bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/30 transition-all group"
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="p-2.5 rounded-lg bg-indigo-500/10 text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <FileText className="h-4 w-4" />
                                        </div>
                                        <div className="text-left">
                                            <span className="font-semibold text-sm text-slate-200 block">Gerenciar Notícias</span>
                                            <span className="text-xs text-slate-500">Editar ou publicar artigos</span>
                                        </div>
                                    </div>
                                    <ArrowRight className="h-4 w-4 text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" />
                                </Link>

                                <Link 
                                    href={route('users.index')}
                                    className="flex items-center justify-between p-4 rounded-xl bg-slate-950 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/30 transition-all group"
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="p-2.5 rounded-lg bg-indigo-500/10 text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <Settings className="h-4 w-4" />
                                        </div>
                                        <div className="text-left">
                                            <span className="font-semibold text-sm text-slate-200 block">Configurações</span>
                                            <span className="text-xs text-slate-500">Gerenciar usuários do sistema</span>
                                        </div>
                                    </div>
                                    <ArrowRight className="h-4 w-4 text-slate-600 group-hover:text-indigo-400 group-hover:translate-x-1 transition-all" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
