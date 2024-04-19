<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sewa Peralatan Outdoor" name="description">
    <meta content="{{ config('app.name') }}" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('src/backend/images/logo-favicon/default-favicon.ico') }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- CSS -->
    <link href="{{ asset('src/backend/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('src/backend/css/app.min.css') }}" rel="stylesheet" id="light-style">
    <link href="{{ asset('src/backend/css/app-dark.min.css') }}" rel="stylesheet" id="dark-style">
    <link href="{{ asset('src/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />

    <style>
        .table-sortable>thead>tr>th.sort {
            cursor: pointer;
            position: relative;
        }

        .table-sortable>thead>tr>th.sort:after,
        .table-sortable>thead>tr>th.sort:after,
        .table-sortable>thead>tr>th.sort:after {
            content: ' ';
            position: absolute;
            height: 0;
            width: 0;
            right: 10px;
            top: 22px;
        }

        .table-sortable>thead>tr>th.sort:after {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #ccc;
            border-bottom: 0px solid transparent;
        }

        .table-sortable>thead>tr>th:hover:after {
            border-top: 5px solid #888;
        }

        .table-sortable>thead>tr>th.sort.asc:after {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 0px solid transparent;
            border-bottom: 5px solid #333;
        }

        .table-sortable>thead>tr>th.sort.asc:hover:after {
            border-bottom: 5px solid #888;
        }

        .table-sortable>thead>tr>th.sort.desc:after {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #333;
            border-bottom: 5px solid transparent;
        }
    </style>
</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <div class="wrapper">
        @livewire('app.backend.partials.left-sidebar')
        <div class="content-page">
            <div class="content">
                @livewire('app.backend.partials.top-bar')

                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>

            @livewire('app.backend.partials.footer')
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('src/backend/js/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('src/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('src/backend/js/vendor.min.js') }}"></script>
    <script src="{{ asset('src/backend/js/app.min.js') }}"></script>

    <script>
        // default configuration Swal:toast
        const swalToast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // default configuration Swal:confirm
        const swalConfirm = Swal.mixin({
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            customClass: {
                cancelButton: 'order-1',
                confirmButton: 'order-2',
            },
            buttonsStyling: true
        });
    </script>

    @stack('js')
</body>

</html>
