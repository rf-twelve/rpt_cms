<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.ico" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    @livewireStyles
</head>

<body class="layout-top-nav">

    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts/panels/navbar_top')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #02366f !important;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-white"> MONITORING DASHBOARD</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <div class="container">
                <div class="row">


                </div>





            </div>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('layouts/panels/footer')
    </div>

    <!-- REQUIRED SCRIPTS -->
    @livewireScripts
    <!-- Scripts -->
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}""></script> --}}
    <script src=" {{ asset('/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('/plugins/chart.js/Chart.min.js') }}"></script> --}}
</body>

</html>
