<nav class="main-header navbar navbar-expand-md navbar-light navbar-primary">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="{{asset('img/lgulopezquezon.png')}}" alt="LGU Kalibo logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light text-white">{{ config('app.name', 'Laravel') }}</span>
        </a>



        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                @if (auth()->check())
                <a class="nav-link text-white" href="{{route('dashboard')}}">
                    <i class="fas fa-home"></i>
                    Main
                </a>
                @else
                <a class="nav-link text-white" href="{{route('login')}}">
                    <i class="fas fa-lock"></i>
                    Login
                </a>
                @endif

            </li>

        </ul>
    </div>
</nav>
