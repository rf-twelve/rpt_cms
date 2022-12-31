<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /*!
        * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
        * Copyright 2015 Daniel Cardoso <@DanielCardoso>
            * Licensed under MIT
            */
            .la-ball-clip-rotate-multiple,
            .la-ball-clip-rotate-multiple > div {
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            }
            .la-ball-clip-rotate-multiple {
            display: block;
            font-size: 0;
            color: #fff;
            }
            .la-ball-clip-rotate-multiple.la-dark {
            color: #333;
            }
            .la-ball-clip-rotate-multiple > div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
            }
            .la-ball-clip-rotate-multiple {
            width: 32px;
            height: 32px;
            }
            .la-ball-clip-rotate-multiple > div {
            position: absolute;
            top: 50%;
            left: 50%;
            background: transparent;
            border-style: solid;
            border-width: 2px;
            border-radius: 100%;
            -webkit-animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
            -moz-animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
            -o-animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
            animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
            }
            .la-ball-clip-rotate-multiple > div:first-child {
            position: absolute;
            width: 32px;
            height: 32px;
            border-right-color: transparent;
            border-left-color: transparent;
            }
            .la-ball-clip-rotate-multiple > div:last-child {
            width: 16px;
            height: 16px;
            border-top-color: transparent;
            border-bottom-color: transparent;
            -webkit-animation-duration: .5s;
            -moz-animation-duration: .5s;
            -o-animation-duration: .5s;
            animation-duration: .5s;
            -webkit-animation-direction: reverse;
            -moz-animation-direction: reverse;
            -o-animation-direction: reverse;
            animation-direction: reverse;
            }
            .la-ball-clip-rotate-multiple.la-sm {
            width: 16px;
            height: 16px;
            }
            .la-ball-clip-rotate-multiple.la-sm > div {
            border-width: 1px;
            }
            .la-ball-clip-rotate-multiple.la-sm > div:first-child {
            width: 16px;
            height: 16px;
            }
            .la-ball-clip-rotate-multiple.la-sm > div:last-child {
            width: 8px;
            height: 8px;
            }
            .la-ball-clip-rotate-multiple.la-2x {
            width: 64px;
            height: 64px;
            }
            .la-ball-clip-rotate-multiple.la-2x > div {
            border-width: 4px;
            }
            .la-ball-clip-rotate-multiple.la-2x > div:first-child {
            width: 64px;
            height: 64px;
            }
            .la-ball-clip-rotate-multiple.la-2x > div:last-child {
            width: 32px;
            height: 32px;
            }
            .la-ball-clip-rotate-multiple.la-3x {
            width: 96px;
            height: 96px;
            }
            .la-ball-clip-rotate-multiple.la-3x > div {
            border-width: 6px;
            }
            .la-ball-clip-rotate-multiple.la-3x > div:first-child {
            width: 96px;
            height: 96px;
            }
            .la-ball-clip-rotate-multiple.la-3x > div:last-child {
            width: 48px;
            height: 48px;
            }
            /*
            * Animation
            */
            @-webkit-keyframes ball-clip-rotate-multiple-rotate {
            0% {
            -webkit-transform: translate(-50%, -50%) rotate(0deg);
            transform: translate(-50%, -50%) rotate(0deg);
            }
            50% {
            -webkit-transform: translate(-50%, -50%) rotate(180deg);
            transform: translate(-50%, -50%) rotate(180deg);
            }
            100% {
            -webkit-transform: translate(-50%, -50%) rotate(360deg);
            transform: translate(-50%, -50%) rotate(360deg);
            }
            }
            @-moz-keyframes ball-clip-rotate-multiple-rotate {
            0% {
            -moz-transform: translate(-50%, -50%) rotate(0deg);
            transform: translate(-50%, -50%) rotate(0deg);
            }
            50% {
            -moz-transform: translate(-50%, -50%) rotate(180deg);
            transform: translate(-50%, -50%) rotate(180deg);
            }
            100% {
            -moz-transform: translate(-50%, -50%) rotate(360deg);
            transform: translate(-50%, -50%) rotate(360deg);
            }
            }
            @-o-keyframes ball-clip-rotate-multiple-rotate {
            0% {
            -o-transform: translate(-50%, -50%) rotate(0deg);
            transform: translate(-50%, -50%) rotate(0deg);
            }
            50% {
            -o-transform: translate(-50%, -50%) rotate(180deg);
            transform: translate(-50%, -50%) rotate(180deg);
            }
            100% {
            -o-transform: translate(-50%, -50%) rotate(360deg);
            transform: translate(-50%, -50%) rotate(360deg);
            }
            }
            @keyframes ball-clip-rotate-multiple-rotate {
            0% {
            -webkit-transform: translate(-50%, -50%) rotate(0deg);
            -moz-transform: translate(-50%, -50%) rotate(0deg);
            -o-transform: translate(-50%, -50%) rotate(0deg);
            transform: translate(-50%, -50%) rotate(0deg);
            }
            50% {
            -webkit-transform: translate(-50%, -50%) rotate(180deg);
            -moz-transform: translate(-50%, -50%) rotate(180deg);
            -o-transform: translate(-50%, -50%) rotate(180deg);
            transform: translate(-50%, -50%) rotate(180deg);
            }
            100% {
            -webkit-transform: translate(-50%, -50%) rotate(360deg);
            -moz-transform: translate(-50%, -50%) rotate(360deg);
            -o-transform: translate(-50%, -50%) rotate(360deg);
            transform: translate(-50%, -50%) rotate(360deg);
            }
            }
    </style>
    @yield('styles')
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts/panels/navbar')
        <!-- Main Sidebar Container -->
        @include('layouts/panels/sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{-- @include('layouts/panels/breadcrumb') --}}
            <!-- /.content-header -->

            <main class="p-2">
                @yield('content')
            </main>
        </div>
        <!-- Main Footer -->
        @include('layouts/panels/footer')
    </div>

    <!-- REQUIRED SCRIPTS -->
    @livewireScripts
    <!-- Scripts -->
    {{-- <script src="{{ asset('/plugins/alpinejs/dist/alpine.js') }}"></script> --}}
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}""></script> --}}
    <script src=" {{ asset('/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script> --}}

    @yield('scripts')

    <script type="text/javascript">
        window.addEventListener('swalSuccess', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Record has been Successfully saved!',
            showConfirmButton: false,
            timer: 1500
        })
    });

    window.addEventListener('swalTransactionSuccess', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Transaction has been Successfully saved!',
            showConfirmButton: false,
            timer: 1500
        })
    });

    window.addEventListener('swalUpdate', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Record has been successfully updated!',
            showConfirmButton: false,
            timer: 1500
        })
    });
    window.addEventListener('swalDelete', event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Record has been successfully deleted!',
            showConfirmButton: false,
            timer: 1500
        })
    });
    window.addEventListener('swalEmptyField', event => {
        Swal.fire({
        position: 'top-end',
            icon: 'warning',
            title: 'Input field is empty!',
            showConfirmButton: false,
            timer: 1500
            })
    });
    window.addEventListener('swalDoubleEntry', event => {
        Swal.fire({
            icon: 'warning',
            title: 'Duplicate Found!',
            text: 'Please check Employee`s list.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalRecordNotFound', event => {
        Swal.fire({
            icon: 'info',
            title: 'Record Not Found!',
            text: 'Please check search field.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalAccountNotVerified', event => {
        Swal.fire({
            icon: 'info',
            title: 'RPT Account not yet verified!',
            text: 'Please verify RPT Account.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalPaymentYearNotFound', event => {
        Swal.fire({
            icon: 'info',
            title: 'Payment Year not found!',
            text: 'Please verify RPT Account.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalAssessedValueNotFound', event => {
        Swal.fire({
            icon: 'info',
            title: 'Assessed Value Not Found!',
            text: 'Please verify RPT Account',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalUnpaidYearNoValue', event => {
        Swal.fire({
            icon: 'info',
            title: 'Unpaid year has no Assessed Value!',
            text: 'Please check RPT Account',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalSearchFieldEmpty', event => {
        Swal.fire({
            icon: 'info',
            title: 'Search field is empty!',
            text: 'Please input keywords on search field.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalPeriodCoveredUnkown', event => {
        Swal.fire({
            icon: 'info',
            title: 'Unkown Payment year covered!',
            text: 'Please check RPT Account payment year covered.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalNoPayment', event => {
        Swal.fire({
            icon: 'info',
            title: 'No payment selected!',
            text: 'Please select payment.',
            showConfirmButton: true,
            })
    });
    window.addEventListener('swalPaymentIsUpdated', event => {
        Swal.fire({
            icon: 'info',
            title: 'Client payment is updated!',
            text: 'No more pending tax due.',
            showConfirmButton: true,
            })
    });

    </script>

</body>

</html>
