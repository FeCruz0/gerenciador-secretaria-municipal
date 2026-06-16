<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<link rel="shortcut icon" href="{{ asset('assets-web/images/favicon.ico') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMAS') }}</title>

    @laravelPWA

    <!-- FONTS -->
    <link href="" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <link href="{{ asset('assets-web/css/site.css') }}" rel="stylesheet">

    @component('web.components.styles')

    @endcomponent
</head>

    <body>
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
              src="{{isset($unit->logo) ? asset('storage/images/units/' . $unit->logo) : ''}}">
              <!-- Uncomment below if you prefer to use an image logo -->
              <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            </div>
            <div class="logo float-start d-lg-none">
              <img class="img-profile"
                src="{{isset($unit->logo) ? asset('storage/images/units/' . $unit->logo) : ''}}">
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
                      <a href="http://www.inea.rj.gov.br/arraial-do-cabo/">Qualidade Ambiental</a></li>
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
                      <a href="{{ route('web_publication.home') }}">Publicações SEMAS</a>
                    </li>
                    <li class="{{ (request()->is('publicacao/pesquisas')) || (request()->is('publicacao/pesquisas')) ? 'active' : '' }}">
                      <a href="{{ route('web_publication.researchs') }}">Pesquisas</a>
                    </li>
                    <li class="{{ (request()->is('publicacao/pesquisas')) || (request()->is('publicacao/pesquisas')) ? 'active' : '' }}">
                        <a href="{{ route('noticias_web_index') }}">Noticias</a>
                      </li>
                  </ul>
                </li>
                <li class="{{ (request()->is('transparencia*')) || (request()->is('transparencia*')) ? 'active' : '' }}">
                  <a href="https://transparencia.arraial.modernizacao.com.br/">Transparência</a>
                  <!--<ul>
                     <li><a href="{{ route('web_expense_index') }}">Despesas</a></li>
                    <li><a href="{{ route('web_legislacoes_index') }}">Legislações</a></li>
                    <li><a href="{{ route('web_revenue_index') }}">Receitas</a></li>

                    <li class="{{ (request()->is('transparencia/portaltransparencia')) || (request()->is('transparencia/portaltransparencia')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.portal') }}">Portal de Transparência</a></li>
                    <li class="{{ (request()->is('transparencia/conselhoambiente')) || (request()->is('transparencia/conselhoambiente')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.environmentcouncil') }}">Conferência Municipal de Meio Ambiente</a>
                    </li>
                    <li class="{{ (request()->is('transparencia/conselhoambiente')) || (request()->is('transparencia/conselhoambiente')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a>
                    </li>
                    <li class="{{ (request()->is('transparencia/outrosconselhos')) || (request()->is('transparencia/outrosconselhos')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.councilparticipation') }}">Participação em Outros Conselhos</a></li>
                    <li class="{{ (request()->is('transparencia/fundoambiente')) || (request()->is('transparencia/fundoambiente')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.environmentfund') }}">Fundo Municipal do Meio Ambiente</a></li>
                    <li class="{{ (request()->is('transparencia/ajusteambiental')) || (request()->is('transparencia/ajusteambiental')) ? 'active' : '' }}">
                      <a href="{{ route('web_transparency.environmentaladjustment') }}">Termo de Ajuste Ambiental</a></li>

                  </ul> -->
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

        <main id="main">
            @include('flash::message')

            @yield('content')
        </main>
         <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="footer-top">
            <div class="container">
                <div class="row">
                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <iframe src="{{ isset($unit->google_maps_iframe) ? $unit->google_maps_iframe : '' }}" height="270" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-lg-3 col-md-6 footer-info">
                    <img class="img-profile" src="{{isset($unit->logo) ? asset('storage/images/units/' . $unit->logo) : ''}}" style="width:197px;margin-left:-5px;">
                    <p><br>
                        {{ isset($unit) ? $unit->sigla : ''}} <br>
                        {{ isset($unit) ? $unit->address : '' }}<br>
                        {{ isset($unit->organization) ? $unit->operation : '' }}<br><br>
                    <strong>Whatsapp:</strong> {{ isset($unit->phone) ? $unit->phone : '' }}<br>
                    <strong>Email:</strong> {{ isset($unit->email) ? $unit->email : '' }}<br>
                    </p>
                    <div class="social-links mt-3">
                        @if(isset($unit))
                          @foreach($unit->socialmedia as $social_media)
                            <a class="share-facebook" href="{{$social_media->pivot->url}}"><i class="{{ $social_media->logo }}" style="color: #ffffff"></i></a>
                          @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Institucional</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_institutional.thesecretariat') }}">A Secretaria</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_institutional.organstructure') }}">Estrutura Organizacional</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_ombudsman') }}">Ouvidoria</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('relatorio_de_gestao_web_index') }}">Relatório de Gestão</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('projects_web_index') }}">Projetos</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('unid_conservacao_web_index') }}">Unidades de Conservação</a></li>
                    </ul>
                    <br>
                    <h4>Serviços</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('licenciamento_ambiental_web') }}">Licenciamento Ambiental</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_services.pruning') }}">Poda</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_services.animalcause') }}">Causa Animal</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_services.environmentprotection') }}">Proteção Ambiental</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_services.environmentquality') }}">Qualidade Ambiental</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_services.environmenteducation') }}">Educação Ambiental</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Meu Ambiente</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_myenvironment.about') }}">Sobre o Programa</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_myenvironment.publicpolicy') }}">Políticas Públicas</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_myenvironment.pillars') }}">Pilares do Programa</a></li>
                    </ul>
                    <br>
                    <h4>Publicação</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_publication.home') }}">Publicações SEMAS</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_publication.researchs') }}">Pesquisas</a></li>
                    </ul>
                    <br>
                    <h4>Transparência</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_transparency.portal') }}">Portal da Transparência</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="{{ route('web_transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a></li>
                    <!-- <li><i class="bx bx-chevron-right"></i>
                        <a href="#">Fundo do Meio Ambiente</a></li>
                    <li><i class="bx bx-chevron-right"></i>
                        <a href="#">Termo de Ajuste Ambiental</a></li> -->
                    </ul>

                </div>

                </div>
            </div>
            </div>

            <div class="container b-5 px-3 pt-3 text-muted text-center text-small">
            <p class="mb-1"> Desenvolvido pela Coordenadoria de Organização e Desenvolvimento Estratégico</p>
            <img src="{{ asset('assets-web/img/pmac-governo.svg') }}" width="130" alt="">
            <img src="{{ asset('assets-web/img/pmac-code.svg') }}" width="130" style="padding-left:10px;margin-left:10px;border-left:1px solid #858796;" alt="">
            </div>
        </footer><!-- End Footer -->

            <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        @component('web.components.scripts')

        @endcomponent
    {{-- JS Script --}}
    @yield('js-script')
    {{-- JS Script --}}
    </body>
</html>
