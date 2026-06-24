import React from 'react';
import { Link, usePage, router as Inertia } from '@inertiajs/react';
import usePermission from '../../Hooks/usePermission';
import { 
    LayoutDashboard, 
    Newspaper, 
    Users, 
    Building2, 
    UserCheck, 
    FileText, 
    FolderOpen, 
    Image, 
    HelpCircle, 
    Bell, 
    ExternalLink, 
    Settings, 
    LogOut,
    Menu,
    User as UserIcon,
    Sliders,
    Shield
} from 'lucide-react';

export default function AdminLayout({ children, title }) {
    const { auth, flash, active_organ } = usePage().props;
    const user = auth?.user;
    const { hasPermission } = usePermission();

    const themeColor = active_organ?.theme_color_hex || '#6366f1'; // Default Indigo-500

    const menuItems = [
        { label: 'Painel', routeName: 'dashboard', icon: LayoutDashboard },
        { label: 'Relatórios de Gestão', routeName: 'relatorio_de_gestao.index', icon: FileText, permission: 'Ver e Listar Relatórios de Gestão' },
        { label: 'Notícias', routeName: 'noticias.index', icon: Newspaper, permission: 'Ver e Listar Notícias' },
        { label: 'Pessoas', routeName: 'pessoas.index', icon: Users, permission: 'Ver e Listar Pessoas' },
        { label: 'Unidades', routeName: 'unidades.index', icon: Building2, permission: 'Ver e Listar Unidades' },
        { label: 'Lideranças', routeName: 'liderancas.index', icon: UserCheck, permission: 'Ver e Listar Liderança' },
        { label: 'Arquivos', routeName: 'arquivos.index', icon: FolderOpen },
        { label: 'Banners', routeName: 'banners.index', icon: Image, permission: 'Ver e Listar Banners' },
        { label: 'FAQ', routeName: 'faqs.index', icon: HelpCircle, permission: 'Ver e Listar FAQ' },
        { label: 'Galeria', routeName: 'galeria_imagens.index', icon: Image, permission: 'Ver e Listar Galeria' },
        { label: 'Notificações', routeName: 'notificacoes.index', icon: Bell, permission: 'Ver e Listar Notificações' },
        { label: 'Atalhos Web', routeName: 'web_atalhos.index', icon: ExternalLink, permission: 'Ver e Listar Atalhos Web' },
        { label: 'Módulos da Home', routeName: 'home_modules.index', icon: Sliders, permission: 'Gerenciar Módulos da Home' },
        { label: 'Órgãos & Subsecretarias', routeName: 'orgaos.index', icon: Building2, permission: 'Gerenciar Entidades' },
        { label: 'Usuários', routeName: 'users.index', icon: Settings, permission: 'Ver e Listar Usuários' },
        { label: 'Regras e Perfis', routeName: 'roles.index', icon: Shield, permission: 'Ver e Listar Regras' },
    ];

    const isRouteActive = (routeName) => {
        try {
            // Remove o .index ou ações da rota para verificar a rota principal ativa
            const baseRoute = routeName.split('.')[0];
            return route().current(`${baseRoute}.*`) || route().current(routeName);
        } catch (e) {
            return false;
        }
    };

    const handleLogout = (e) => {
        e.preventDefault();
        if (confirm('Tem certeza que deseja sair do sistema?')) {
            Inertia.post(route('logout'));
        }
    };

    return (
        <div className="min-h-screen flex bg-slate-950 text-slate-100 font-sans">
            
            {/* Sidebar */}
            <aside className="w-64 bg-slate-900 border-r border-slate-800 flex flex-col shrink-0">
                {/* Header/Logo */}
                <div className="h-16 flex items-center px-6 border-b border-slate-800 gap-2">
                    <Building2 className="h-6 w-6" style={{ color: themeColor }} />
                    <span className="font-bold text-lg text-slate-100 tracking-tight">{active_organ?.sigla || 'GESEM'} Painel</span>
                </div>

                {/* Navigation Links */}
                <nav className="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    {menuItems.filter(item => !item.permission || hasPermission(item.permission)).map((item, idx) => {
                        const Icon = item.icon;
                        const active = isRouteActive(item.routeName);
                        return (
                            <Link
                                key={idx}
                                href={route(item.routeName)}
                                className={`flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all ${
                                    active 
                                        ? '' 
                                        : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50'
                                }`}
                                style={active ? {
                                    backgroundColor: `${themeColor}1a`, // 10% opacity hex
                                    color: themeColor,
                                    borderLeft: `4px solid ${themeColor}`,
                                    paddingLeft: '0.5rem'
                                } : {}}
                            >
                                <Icon className="h-4.5 w-4.5 shrink-0" />
                                <span>{item.label}</span>
                            </Link>
                        );
                    })}
                </nav>

                {/* Footer/Logout */}
                <div className="p-4 border-t border-slate-800">
                    <button
                        onClick={handleLogout}
                        className="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all border border-transparent hover:border-red-500/20"
                    >
                        <LogOut className="h-4.5 w-4.5 shrink-0" />
                        <span>Sair do Sistema</span>
                    </button>
                </div>
            </aside>

            {/* Main Area */}
            <div className="flex-1 flex flex-col overflow-hidden">
                {/* Header Navbar */}
                <header className="h-16 bg-slate-900/80 backdrop-blur border-b border-slate-800 flex items-center justify-between px-8 z-10 shrink-0">
                    <div className="flex items-center gap-4">
                        <button className="lg:hidden text-slate-400 hover:text-slate-100">
                            <Menu className="h-6 w-6" />
                        </button>
                        <h2 className="font-semibold text-lg text-slate-200">{title}</h2>
                    </div>

                    {/* User Profile */}
                    {user && (
                        <div className="flex items-center gap-3">
                            <div className="text-right hidden sm:block">
                                <p className="text-sm font-medium text-slate-200">{user.name}</p>
                                <p className="text-xs text-slate-500">{user.occupation}</p>
                            </div>
                            <div 
                                className="h-9 w-9 rounded-full flex items-center justify-center"
                                style={{
                                    backgroundColor: `${themeColor}33`, // 20% opacity hex
                                    border: `1px solid ${themeColor}4d`, // 30% opacity hex
                                    color: themeColor
                                }}
                            >
                                {user.profile_photo_path ? (
                                    <img src={`/storage/${user.profile_photo_path}`} alt={user.name} className="h-9 w-9 rounded-full object-cover" />
                                ) : (
                                    <UserIcon className="h-4 w-4" />
                                )}
                            </div>
                        </div>
                    )}
                </header>

                {/* Content View */}
                <main className="flex-1 overflow-y-auto p-8 relative">
                    
                    {/* Alertas/Mensagens Flash */}
                    {flash?.success && (
                        <div className="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm flex items-center justify-between">
                            <span>{flash.success}</span>
                        </div>
                    )}
                    {flash?.error && (
                        <div className="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center justify-between">
                            <span>{flash.error}</span>
                        </div>
                    )}

                    {children}
                </main>

                {/* Footer */}
                <footer className="h-12 border-t border-slate-800 bg-slate-900/50 flex items-center justify-between px-8 text-xs text-slate-500 shrink-0">
                    <p>&copy; {new Date().getFullYear()} {active_organ?.sigla || 'GESEM'}. Todos os direitos reservados.</p>
                    <p className="hidden md:block">{active_organ?.name || 'Gerenciador de Secretaria Municipal'}</p>
                </footer>
            </div>
        </div>
    );
}
