<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                style="background: url('{{ asset('img/bg-rpt.jpg')}}') center center;">
                <h3 class="widget-user-username text-center text-primary" style="background:rgba(255, 255, 255, 0.877)">
                    <b>LGU LOPEZ</b>
                </h3>
                <h5 class="widget-user-desc text-center text-dark" style="background:rgba(255, 255, 255, 0.877)">
                    Municipal Treasury Management System</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="{{asset('img/lgulopezquezon.png')}}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 text-center">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input name="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                    required autocomplete="username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @if ($errors->any())
                                <span class="invalid-feedback" role="alert">
                                    <strong>error</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check"></i>
                                Login</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <!-- /.center -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>


</html>
