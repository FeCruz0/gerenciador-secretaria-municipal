
<!-- ======= Top Bar ======= -->
<section id="topbar">
  <div class="container clearfix">
    <div class="contact-info float-start">
        <a href="mailto:grc@{{ isset($unit->email) ? $unit->email : '' }}"><i class="fa fa-envelope"></i>{{ isset($unit->email) ? $unit->email : '' }}</a>
        <a href="{{ isset($unit->phone) ? $unit->phone : '' }}"><i class="fab fa-whatsapp"></i> {{ isset($unit->phone) ? $unit->phone : '' }}</a>
    </div>
    <div class="social-links float-end">
        @if(isset($unit))
          @foreach($unit->socialmedia as $social_media)
            <a class="share-facebook" href="{{$social_media->pivot->url}}"><i class="{{ $social_media->logo }}" style="color: #3890c2"></i></a>
          @endforeach
        @endif
    </div>
  </div>
</section>

<!-- ======= Header ======= -->
<header id="header">
  <div class="container">

    <div class="logo float-start d-none d-xl-block">
    <img class="img-profile"
      src="{{ (isset($unit) && $unit->logo) ? asset('storage/images/units/' . $unit->logo) : asset('assets-web/img/pmac-governo.svg') }}">
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    </div>
    <div class="logo float-start d-lg-none">
      <img class="img-profile"
        src="{{ (isset($unit) && $unit->logo) ? asset('storage/images/units/' . $unit->logo) : asset('assets-web/img/pmac-governo.svg') }}">
    </div>

    <nav class="nav-menu float-end d-none d-lg-block">
      <ul>
        <li class="{{ (request()->is('/')) || (request()->is('/')) ? 'active' : '' }}">
          <a href="{{ route('web_home') }}">Início</a></li>
        <li class="drop-down {{ (request()->is('institucional*')) || (request()->is('institucional*')) ? 'active' : '' }}">
          <a href="">Institucional</a>
          <ul>
            <li class="{{ (request()->is('institucional/asecretaria')) || (request()->is('institucional/asecretaria')) ? 'active' : '' }}">
              <a href="{{ route('web_institutional.thesecretariat') }}">A Secretaria</a></li>
            <li class="{{ (request()->is('institucional/estrutura')) || (request()->is('institucional/estrutura')) ? 'active' : '' }}">
              <a href="{{ route('web_institutional.organstructure') }}">Estrutura Organizacional</a></li>
            <li class="{{ (request()->is('ouvidoria')) || (request()->is('ouvidoria')) ? 'active' : '' }}">
              <a href="{{ route('web_ouvidoria') }}">Ouvidoria</a>
            <li class="{{ (request()->is('institucional/relatoriogestao')) || (request()->is('institucional/relatoriogestao')) ? 'active' : '' }}">
              <a href="{{ route('relatorio_de_gestao_web_index') }}">Relatório de Gestão</a></li>
            <li class="{{ (request()->is('institucional/projetos')) || (request()->is('institucional/projetos')) ? 'active' : '' }}">
              <a href="{{ route('projects_web_index') }}">Projetos</a></li>
            <li class="{{ (request()->is('institucional/unidadesconservacao')) || (request()->is('institucional/unidadesconservacao')) ? 'active' : '' }}">
              <a href="{{ route('unid_conservacao_web_index') }}">Unidades de Conservação</a></li>
          </ul></li>
        <li class="drop-down {{ (request()->is('servicos*')) || (request()->is('servicos*')) ? 'active' : '' }}">
          <a href="">Serviços</a>
          <ul>
            <li class="{{ (request()->is('servicos/licenciamentoambiental')) || (request()->is('servicos/licenciamentoambiental')) ? 'active' : '' }}">
              <a href="{{ route('licenciamento_ambiental_web') }}">Licenciamento Ambiental</a></li>
            <li class="{{ (request()->is('servicos/poda')) || (request()->is('servicos/poda')) ? 'active' : '' }}">
              <a href="{{ route('web_services.pruning') }}">Poda</a></li>
            <li class="{{ (request()->is('servicos/causaanimal')) || (request()->is('servicos/causaanimal')) ? 'active' : '' }}">
              <a href="{{ route('web_services.animalcause') }}">Causa Animal</a></li>
            <li class="{{ (request()->is('servicos/protecaoambiental')) || (request()->is('servicos/protecaoambiental')) ? 'active' : '' }}">
              <a href="{{ route('web_services.environmentprotection') }}">Proteção Ambiental</a></li>
            <li class="{{ (request()->is('servicos/qualidadeambiental')) || (request()->is('servicos/qualidadeambiental')) ? 'active' : '' }}">
              <a href="http://www.inea.rj.gov.br/arraial-do-cabo/" target="_blank">Qualidade Ambiental</a></li>
            <li class="{{ (request()->is('servicos/educacaoambiental')) || (request()->is('servicos/educacaoambiental')) ? 'active' : '' }}">
              <a href="{{ route('web_services.environmenteducation') }}">Educação Ambiental</a></li>
          </ul></li>
        <li class="drop-down {{ (request()->is('meuambiente*')) || (request()->is('meuambiente*')) ? 'active' : '' }}">
          <a href="">Programa Meu Ambiente</a>
          <ul>
            <li class="{{ (request()->is('meuambiente/sobre')) || (request()->is('meuambiente/sobre')) ? 'active' : '' }}">
              <a href="{{ route('web_myenvironment.about') }}">Sobre o Programa</a></li>
            <li class="{{ (request()->is('meuambiente/politicaspublicas')) || (request()->is('meuambiente/politicaspublicas')) ? 'active' : '' }}">
              <a href="{{ route('web_myenvironment.publicpolicy') }}">Políticas Públicas</a></li>
            <li class="{{ (request()->is('meuambiente/pilares')) || (request()->is('meuambiente/pilares')) ? 'active' : '' }}">
              <a href="{{ route('web_myenvironment.pillars') }}">Pilares do Programa</a></li>
            <!-- <li class="{{ (request()->is('meuambiente/campanhas')) || (request()->is('meuambiente/campanhas')) ? 'active' : '' }}">
              <a href="{{ route('web_myenvironment.campaign') }}">Ações e Campanhas</a></li> -->
          </ul></li>
        <li class="drop-down {{ (request()->is('publicacoes')) || (request()->is('publicacao*')) ? 'active' : '' }}">
          <a href="">Publicações</a>
          <ul>
            <li class="{{ (request()->is('publicacao/publicacoessemas')) || (request()->is('publicacao/publicacoessemas')) ? 'active' : '' }}">
              <a href="{{ route('web_publication.home') }}">Publicações {{ app()->has('active_organ') ? app('active_organ')->sigla : 'Prefeitura Municipal' }}</a>
            </li>
            <li class="{{ (request()->is('publicacao/pesquisas')) || (request()->is('publicacao/pesquisas')) ? 'active' : '' }}">
              <a href="{{ route('web_publication.researchs') }}">Pesquisas</a>
            </li>
            <li class="{{ (request()->is('publicacao/pesquisas')) || (request()->is('publicacao/pesquisas')) ? 'active' : '' }}">
                <a href="{{ route('noticias_web_index') }}">Noticias</a>
              </li>
          </ul>
        </li>
        <li class="drop-down {{ (request()->is('transparencia*')) || (request()->is('transparencia*')) ? 'active' : '' }}">
          <a href="">Transparência</a>
          <ul>
            <li><a href="{{ route('web_expense_index') }}">Despesas</a></li>
            <li><a href="{{ route('web_legislacoes_index') }}">Legislações</a></li>
            <li><a href="{{ route('web_bididng_agreement_index') }}">Contratações Públicas - Contratos</a></li>
            <li><a href="{{ route('web_direct_hire_index') }}">Contratações Públicas - Cont. Direta</a></li>
            <li><a href="{{ route('web_bididng_index') }}">Contratações Públicas - Licitação</a></li>
            <li><a href="{{ route('web_revenue_index') }}">Receitas</a></li>

            <!--<li class="{{ (request()->is('transparencia/portaltransparencia')) || (request()->is('transparencia/portaltransparencia')) ? 'active' : '' }}">
              <a href="{{ route('web_transparency.portal') }}">Portal de Transparência</a></li>-->
            <li class="{{ (request()->is('transparencia/conselhoambiente')) || (request()->is('transparencia/conselhoambiente')) ? 'active' : '' }}">
              <a href="{{ route('web_transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a>
            </li>
            <!-- <li class="{{ (request()->is('transparencia/outrosconselhos')) || (request()->is('transparencia/outrosconselhos')) ? 'active' : '' }}">
              <a href="{{ route('web_transparency.councilparticipation') }}">Participação em Outros Conselhos</a></li>
            <li class="{{ (request()->is('transparencia/fundoambiente')) || (request()->is('transparencia/fundoambiente')) ? 'active' : '' }}">
              <a href="{{ route('web_transparency.environmentfund') }}">Fundo Municipal do Meio Ambiente</a></li>
            <li class="{{ (request()->is('transparencia/ajusteambiental')) || (request()->is('transparencia/ajusteambiental')) ? 'active' : '' }}">
              <a href="{{ route('web_transparency.environmentaladjustment') }}">Termo de Ajuste Ambiental</a></li> -->

          </ul>
        </li>

        <li class="{{ (request()->is('faq')) || (request()->is('faq')) ? 'active' : '' }}">
          <a href="{{ route('web_faq') }}">Perguntas Frequentes</a>
        </li>

        <li class="drop-down"> <a href="">Servidor</a>
          <ul>
            <li class="">
              <a class="employee-menu-link" href="{{ route('login') }}">Login</a></li>
            <li class="">
              <a href="https://mail.hostinger.com/">E-mail</a></li>
            <li class="">
              <a href="https://www.arraial.rj.gov.br/">PMAC</a>
            <li class="">
              <a href="https://www.arraial.rj.gov.br/portal/diario-oficial">Diário Oficial</a></li>
            <li class="">
              <a href="http://45.70.23.82:8091/iss-web/">ISS - Arraial do Cabo</a></li>
          </ul>
        </li>

      </ul>
    </nav><!-- .nav-menu -->

  </div>
</header><!-- End Header -->
