<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title inertia>{{ config('app.name', 'Painel Administrativo') }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Inertia app JS --}}
  @routes
  @viteReactRefresh
  @vite('resources/js/app.jsx')
</head>

<body class="bg-slate-950 text-slate-100 font-sans antialiased scroll-smooth">
  @inertia
</body>
</html>
