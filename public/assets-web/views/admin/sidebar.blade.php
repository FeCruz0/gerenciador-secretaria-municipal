<ul class="navbar-nav bg-light color-theme sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{asset('img/pmac-gira-renda-cabista-logo.svg')}}" alt="" width="80%" data-anime="50">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active"  data-anime="100">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-home"></i>
            <span>Início</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" data-anime="200">
        Renda
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item" data-anime="300">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-redo"></i>
            <span>Carregar Dados</span>
        </a>
    </li>
    <li class="nav-item" data-anime="400">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true">
            <i class="far fa-file"></i>
            <span>Auditoria</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" data-anime="500">
        Relatórios
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item" data-anime="600">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true" >
            <i class="fas fa-check"></i>
            <span>Contemplados</span>
        </a>
    </li>
    <li class="nav-item" data-anime="700">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true" >
            <i class="far fa-file"></i>
            <span>Cadastrados</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Nav Item - Charts -->
    <div class="sidebar-heading" data-anime="800">
        Config
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item" data-anime="900">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Planilhas</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>