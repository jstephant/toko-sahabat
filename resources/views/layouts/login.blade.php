<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ $asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ $asset('css/app.css') }}" rel="stylesheet">

    <!-- Core -->
    <script src="{{ $asset('vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ $asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ $asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Argon CSS -->
    <link type="text/css" href="{{ $asset('css/argon-pro.css?v=1.0.0') }}" rel="stylesheet">

    <!-- Argon JS -->
    <script src="{{ $asset('js/argon-pro.js?v=1.1.0') }}"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	  <!-- Icons -->
    <link href="{{ $asset('vendor/nucleo/css/nucleo.css?v=1.0.0') }}" rel="stylesheet">
	<link href="{{ $asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
</head>
<body class="bg-default g-sidenav-show g-sidenav-hidden">
    <div class="header py-7 py-lg-6 pt-lg-9">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Welcome!</h1>
                        <p class="text-lead text-white"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt--8 pb-5">
        @yield('content')
    </div>
</body>
</html>
