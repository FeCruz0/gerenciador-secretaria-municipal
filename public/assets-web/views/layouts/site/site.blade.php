<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMAS') }}</title>

    @laravelPWA

    <!-- Custom fonts for this template-->
    <link href="" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets-web/css/owl.carousel.css">
    <link rel="stylesheet" href="assets-web/css/owl.theme.default.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ mix('css/site.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

    {{-- Vendor Styles --}}
        @yield('css-style')
    {{-- Theme Styles --}}
</head>
    
    <body>
        @component('components.navbar')

        @endcomponent
        
        <main id="main">
            @include('flash::message')
               
            @yield('content')
        </main>
        @component('components.footer')

        @endcomponent
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <script src="{{ mix('js/site.js') }}" defer></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- JS Script --}}
    @yield('js-script')
    {{-- JS Script --}}
    </body>
</html>