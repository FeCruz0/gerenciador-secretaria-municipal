
<!-- ======= Top Bar ======= -->
<section id="topbar">
  <div class="container clearfix">
    <div class="contact-info float-start">
      <i class="fa fa-envelope"></i><a href="mailto:grc@arraial.rj.gov.br">gab.ambiente@arraial.rj.gov.br</a>
      <i class="fab fa-whatsapp"></i> 22 99758-7289
    </div>
    <div class="social-links float-end">
      <a href="https://www.facebook.com/PrefeituraArraialDoCabo" class="facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/semas.ac/" class="instagram"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
</section>

<!-- ======= Header ======= -->
<header id="header">
  <div class="container">

    <div class="logo float-start d-none d-xl-block">
    <img class="img-profile"
      src="{{ asset('img/semas-logo.svg')}}">
      <!-- <h1 class="text-light"><a href="index.html"><span>Mamba</span></a></h1> -->
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    </div>
    <div class="logo float-start d-lg-none">
      <img class="img-profile"
        src="{{ asset('img/semas-logo.svg')}}">
    </div>
    <nav class="nav-menu float-end d-none d-lg-block">
      <ul>
        <li class="{{ (request()->is('/')) || (request()->is('/')) ? 'active' : '' }}">
          <a href="{{ route('home') }}">Início</a></li>
        <li class="drop-down {{ (request()->is('institucional*')) || (request()->is('institucional*')) ? 'active' : '' }}">
          <a href="">Institucional</a>
          <ul>
            <li class="{{ (request()->is('institucional/asecretaria')) || (request()->is('institucional/asecretaria')) ? 'active' : '' }}">
              <a href="{{ route('institutional.thesecretariat') }}">A Secretaria</a></li>
            <li class="{{ (request()->is('institucional/estrutura')) || (request()->is('institucional/estrutura')) ? 'active' : '' }}">
              <a href="{{ route('institutional.organstructure') }}">Estrutura Organizacional</a></li>
            <li class="{{ (request()->is('institucional/atendimento')) || (request()->is('institucional/atendimento')) ? 'active' : '' }}">
              <a href="{{ route('institutional.customerservice') }}">Atendimento Público</a></li>
            <li class="{{ (request()->is('institucional/relatoriogestao')) || (request()->is('institucional/relatoriogestao')) ? 'active' : '' }}">
              <a href="{{ route('institutional.managementreport') }}">Relatório de Gestão</a></li>
            <li class="{{ (request()->is('institucional/projetos')) || (request()->is('institucional/projetos')) ? 'active' : '' }}">
              <a href="{{ route('institutional.projects') }}">Projetos</a></li>
            <li class="{{ (request()->is('institucional/unidadesconservacao')) || (request()->is('institucional/unidadesconservacao')) ? 'active' : '' }}">
              <a href="{{ route('institutional.conservationunits') }}">Unidades de Conservação</a></li>
          </ul></li>
        <li class="drop-down {{ (request()->is('servicos*')) || (request()->is('servicos*')) ? 'active' : '' }}">
          <a href="">Serviços</a>
          <ul>
            <li class="{{ (request()->is('servicos/licenciamentoambiental')) || (request()->is('servicos/licenciamentoambiental')) ? 'active' : '' }}">
              <a href="{{ route('services.environmentlicensing.home') }}">Licenciamento Ambiental</a></li>
            <li class="{{ (request()->is('servicos/poda')) || (request()->is('servicos/poda')) ? 'active' : '' }}">
              <a href="{{ route('services.pruning') }}">Poda</a></li>
            <li class="{{ (request()->is('servicos/causaanimal')) || (request()->is('servicos/causaanimal')) ? 'active' : '' }}">
              <a href="{{ route('services.animalcause') }}">Causa Animal</a></li>
            <li class="{{ (request()->is('servicos/protecaoambiental')) || (request()->is('servicos/protecaoambiental')) ? 'active' : '' }}">
              <a href="{{ route('services.environmentprotection') }}">Proteção Ambiental</a></li>
            <li class="{{ (request()->is('servicos/qualidadeambiental')) || (request()->is('servicos/qualidadeambiental')) ? 'active' : '' }}">
              <a href="{{ route('services.environmentquality') }}">Qualidade Ambiental</a></li>
            <li class="{{ (request()->is('servicos/educacaoambiental')) || (request()->is('servicos/educacaoambiental')) ? 'active' : '' }}">
              <a href="{{ route('services.environmenteducation') }}">Educação Ambiental</a></li>
          </ul></li>
        <li class="drop-down {{ (request()->is('meuambiente*')) || (request()->is('meuambiente*')) ? 'active' : '' }}">
          <a href="">Programa Meu Ambiente</a>
          <ul>
            <li class="{{ (request()->is('meuambiente/sobre')) || (request()->is('meuambiente/sobre')) ? 'active' : '' }}">
              <a href="{{ route('myenvironment.about') }}">Sobre o Programa</a></li>
            <li class="{{ (request()->is('meuambiente/politicaspublicas')) || (request()->is('meuambiente/politicaspublicas')) ? 'active' : '' }}">
              <a href="{{ route('myenvironment.publicpolicy') }}">Políticas Públicas</a></li>
            <li class="{{ (request()->is('meuambiente/pilares')) || (request()->is('meuambiente/pilares')) ? 'active' : '' }}">
              <a href="{{ route('myenvironment.pillars') }}">Pilares do Programa</a></li>
            <!-- <li class="{{ (request()->is('meuambiente/campanhas')) || (request()->is('meuambiente/campanhas')) ? 'active' : '' }}">
              <a href="{{ route('myenvironment.campaign') }}">Ações e Campanhas</a></li> -->
          </ul></li>
        <li class="drop-down {{ (request()->is('publicacao*')) || (request()->is('publicacao*')) ? 'active' : '' }}">
          <a href="">Publicação</a>
          <ul>
            <li class="{{ (request()->is('publicacao/publicacoessemas')) || (request()->is('publicacao/publicacoessemas')) ? 'active' : '' }}">
              <a href="{{ route('publication.home') }}">Publicações SEMAS</a></li>
            <li class="{{ (request()->is('publicacao/pesquisas')) || (request()->is('publicacao/pesquisas')) ? 'active' : '' }}">
              <a href="{{ route('publication.researchs') }}">Pesquisas</a></li>
          </ul></li>
        <li class="drop-down {{ (request()->is('transparencia*')) || (request()->is('transparencia*')) ? 'active' : '' }}">
          <a href="">Transparência</a>
          <ul>
            <li class="{{ (request()->is('transparencia/portaltransparencia')) || (request()->is('transparencia/portaltransparencia')) ? 'active' : '' }}">
              <a href="{{ route('transparency.portal') }}">Portal de Transparência</a></li>
            <li class="{{ (request()->is('transparencia/conselhoambiente')) || (request()->is('transparencia/conselhoambiente')) ? 'active' : '' }}">
              <a href="{{ route('transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a></li>
            <!-- <li class="{{ (request()->is('transparencia/outrosconselhos')) || (request()->is('transparencia/outrosconselhos')) ? 'active' : '' }}">
              <a href="{{ route('transparency.councilparticipation') }}">Participação em Outros Conselhos</a></li>
            <li class="{{ (request()->is('transparencia/fundoambiente')) || (request()->is('transparencia/fundoambiente')) ? 'active' : '' }}">
              <a href="{{ route('transparency.environmentfund') }}">Fundo Municipal do Meio Ambiente</a></li>
            <li class="{{ (request()->is('transparencia/ajusteambiental')) || (request()->is('transparencia/ajusteambiental')) ? 'active' : '' }}">
              <a href="{{ route('transparency.environmentaladjustment') }}">Termo de Ajuste Ambiental</a></li> -->
          </ul></li>
        <li class="{{ (request()->is('legislacao')) || (request()->is('legislacao')) ? 'active' : '' }}">
          <a href="{{ route('legislation') }}">Legislação</a></li>
        <li class="{{ (request()->is('faq')) || (request()->is('faq')) ? 'active' : '' }}">
          <a href="{{ route('faq') }}">Perguntas Frequentes</a></li>
      </ul>
    </nav><!-- .nav-menu -->

  </div>
</header><!-- End Header -->