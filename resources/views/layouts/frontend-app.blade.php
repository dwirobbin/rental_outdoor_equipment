<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="Sewa Peralatan Outdoor" name="description">
    <meta content="{{ config('app.name') }}" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('src/backend/images/logo-favicon/default-favicon.ico') }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link href="{{ asset('src/frontend/css/open-iconic-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('src/frontend/css/animate.css') }}" rel="stylesheet">

    <link href="{{ asset('src/frontend/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('src/frontend/css/owl.theme.default.min.css') }}" rel="stylesheet">

    <link href="{{ asset('src/frontend/css/aos.css') }}" rel="stylesheet">

    <link href="{{ asset('src/frontend/css/ionicons.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <link rel="stylesheet" href="{{ asset('src/frontend/css/bootstrap-datepicker.css') }}">

    <link href="{{ asset('src/frontend/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('src/frontend/css/icomoon.css') }}" rel="stylesheet">

    <link href="{{ asset('src/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('src/frontend/css/style.css') }}" rel="stylesheet">

    @stack('css')
</head>

<body>

    @livewire('app.frontend.partials.nav-bar')

    @isset($slot)
        {{ $slot }}
    @endisset

    @livewire('app.frontend.partials.footer')

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#0356fc" />
        </svg>
    </div>

    <script src="{{ asset('src/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/jquery-migrate-3.0.1.min.js') }}"></script>

    <script src="{{ asset('src/frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/aos.js') }}"></script>
    <script src="{{ asset('src/frontend/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('src/frontend/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('src/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('src/frontend/js/main.js') }}"></script>

</body>

</html>
