<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name', 'Girarenda') }}</title>
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template-educ.css') }}">
    <link rel="stylesheet" href="{{ asset('css/simple-anime.css') }}">
</head>

@laravelPWA

<body id="page-top">
    <div id="wrapper">

        @include('admin.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('admin.navbar')

                @yield('content')



            </div>

            @include('admin.footer')

        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/jquery.min.js') }}"></script>
    <script src="{{ mix('js/blur.js') }}"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/admin.js') }}"></script>
    <script src="{{ mix('js/popper.js') }}" defer></script>
    <script src="{{ asset('js/sb-admin-2.js') }}" defer></script>
    <script src="{{ asset('js/simple-anime.js') }}"></script>
    



</body>

</html>
