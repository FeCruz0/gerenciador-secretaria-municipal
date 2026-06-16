@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php $configData = Helper::applClasses(); @endphp
<!DOCTYPE html>
<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
  @if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Painel Administrativo">
  <meta name="author" content="CODE">

  <title inertia>{{ config('app.name', 'Painel Administrativo') }}</title>

  <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Vendor + Theme CSS --}}
  @include('panels/styles')

  {{-- Inertia app JS --}}
  @routes
  @viteReactRefresh
  @vite('resources/js/app.jsx')
</head>

<body
  class="vertical-layout vertical-menu-modern {{ $configData['contentLayout'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['verticalMenuNavbarType'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}"
  data-open="click"
  data-menu="vertical-menu-modern"
  data-col="{{ $configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}"
  data-framework="laravel"
  data-asset-path="{{ asset('/') }}">

  {{-- Navbar --}}
  @include('panels.navbar')

  {{-- Sidebar --}}
  @include('panels.sidebar')

  {{-- Content area where Inertia renders --}}
  <div class="app-content content {{ $configData['pageClass'] }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
      <div class="content-body">
        @inertia
      </div>
    </div>
  </div>

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  {{-- Footer --}}
  @include('panels/footer')

  {{-- Vendor + Theme JS --}}
  @include('panels/scripts')

  <script type="text/javascript">
    $(window).on('load', function () {
      if (feather) {
        feather.replace({ width: 14, height: 14 });
      }
    });
  </script>

  {{-- Inertia SPA Navigation: intercepta links da sidebar/navbar para evitar full page reload --}}
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
      // Aguarda o Inertia estar disponível (js/app.js é defer)
      function attachInertiaLinks() {
        if (!window.Inertia) {
          setTimeout(attachInertiaLinks, 100);
          return;
        }

        // Seleciona todos os links da sidebar e navbar (excluindo logout, externos e âncoras)
        var selectors = [
          '.main-menu a[href]',
          '.navbar-container a[href]',
        ];

        document.querySelectorAll(selectors.join(', ')).forEach(function (link) {
          var href = link.getAttribute('href');

          // Ignora: javascript:void, âncoras, links externos, logout form
          if (!href || href === '#' || href.startsWith('javascript') ||
              href.startsWith('http') || href.startsWith('//') ||
              link.closest('#logout-form') ||
              link.getAttribute('target') === '_blank') {
            return;
          }

          // Ignora se já foi processado
          if (link.dataset.inertia) return;
          link.dataset.inertia = '1';

          link.addEventListener('click', function (e) {
            e.preventDefault();
            window.Inertia.visit(href);
          });
        });
      }

      attachInertiaLinks();
    });
  </script>
</body>
</html>
