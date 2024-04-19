<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('src/backend/images/logo-favicon/default-favicon.ico') }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- App css -->
    <link href="{{ asset('src/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/backend/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />

</head>

<body class="loading authentication-bg"
    data-layout-config='{"leftSideBarTheme":"dark", "layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false, "darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages pt-2 pt-sm-3 pb-2 pb-sm-3">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </div>

    <!-- bundle -->
    <script src="{{ asset('src/backend/js/vendor.min.js') }}"></script>
    <script src="{{ asset('src/backend/js/app.min.js') }}"></script>

    @stack('js')
</body>

</html>
